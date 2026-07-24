<?php

namespace api\controllers;

use Yii;
use backend\models\Img;
use backend\models\Video;

/**
 * Gallery (Img model) and video listing endpoints.
 */
class MediaController extends BaseApiController
{
    private const GALLERY_PAGE_SIZE = 12;
    private const VIDEO_PAGE_SIZE = 9;

    public function actionGallery()
    {
        $lang = $this->resolveLang();
        $page = max(1, (int) Yii::$app->request->get('page', 1));
        $query = Img::find()->where(['status' => 1])->orderBy('id DESC');
        $total = (clone $query)->count();
        $items = $query->offset(($page - 1) * self::GALLERY_PAGE_SIZE)->limit(self::GALLERY_PAGE_SIZE)->asArray()->all();

        return $this->success(
            array_map(fn($i) => $this->mapImg($i, $lang), $items),
            ['page' => $page, 'pageSize' => self::GALLERY_PAGE_SIZE, 'total' => (int) $total]
        );
    }

    public function actionGalleryFull($id)
    {
        $lang = $this->resolveLang();
        $img = Img::find()->where(['id' => $id])->asArray()->one();
        if (!$img) {
            return $this->fail('NOT_FOUND', 'Rasm topilmadi.', null, 404);
        }
        return $this->success($this->mapImg($img, $lang, true));
    }

    public function actionVideo()
    {
        $lang = $this->resolveLang();
        $page = max(1, (int) Yii::$app->request->get('page', 1));
        $query = Video::find()->where(['status' => 1])->orderBy('id DESC');
        $total = (clone $query)->count();
        $items = $query->offset(($page - 1) * self::VIDEO_PAGE_SIZE)->limit(self::VIDEO_PAGE_SIZE)->asArray()->all();

        return $this->success(
            array_map(fn($v) => ['id' => (int) $v['id'], 'video' => $this->assetUrl($v['video']), 'url' => $v['url']], $items),
            ['page' => $page, 'pageSize' => self::VIDEO_PAGE_SIZE, 'total' => (int) $total]
        );
    }

    private function mapImg($img, $lang, $withContent = false)
    {
        $data = [
            'id' => (int) $img['id'],
            'title' => $img['title_' . $lang],
            'img' => $this->assetUrl($img['img']),
            'slug' => $img['slug'],
        ];
        if ($withContent) {
            $data['content'] = $this->assetUrlsInHtml($img['content_' . $lang]);
        }
        return $data;
    }
}
