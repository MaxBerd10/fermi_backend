<?php

namespace api\controllers;

use Yii;
use backend\models\Post;
use backend\models\Postcategory;

/**
 * News endpoints: site-wide listing (legacy site/all), category listing
 * (legacy site/news, matched by Postcategory slug), and single-article detail
 * (legacy site/detail, matched by Post's own slug) which increments `seen`.
 */
class NewsController extends BaseApiController
{
    private const PAGE_SIZE_ALL = 9;
    private const PAGE_SIZE_CATEGORY = 9;

    public function actionIndex()
    {
        $lang = $this->resolveLang();
        $page = max(1, (int) Yii::$app->request->get('page', 1));
        $query = Post::find()->where(['status' => 1])->orderBy('id DESC');
        $total = (clone $query)->count();
        $items = $query->offset(($page - 1) * self::PAGE_SIZE_ALL)->limit(self::PAGE_SIZE_ALL)->all();

        return $this->success(
            array_map(fn($p) => $this->mapPost($p, $lang), $items),
            ['page' => $page, 'pageSize' => self::PAGE_SIZE_ALL, 'total' => (int) $total]
        );
    }

    public function actionCategory($slug)
    {
        $lang = $this->resolveLang();
        $menuId = Yii::$app->request->get('menuId');
        $page = max(1, (int) Yii::$app->request->get('page', 1));

        $category = Postcategory::find()->where(['slug' => $slug])->asArray()->one();
        if (!$category) {
            return $this->fail('NOT_FOUND', 'Yangiliklar bo\'limi topilmadi.', null, 404);
        }

        $query = Post::find()->where(['status' => 1, 'category_id' => $category['id']])->orderBy('date DESC');
        $total = (clone $query)->count();
        $items = $query->offset(($page - 1) * self::PAGE_SIZE_CATEGORY)->limit(self::PAGE_SIZE_CATEGORY)->all();

        return $this->success([
            'category' => ['id' => (int) $category['id'], 'title' => $category['title_' . $lang], 'slug' => $category['slug']],
            'menuId' => $menuId ? (int) $menuId : null,
            'items' => array_map(fn($p) => $this->mapPost($p, $lang), $items),
        ], ['page' => $page, 'pageSize' => self::PAGE_SIZE_CATEGORY, 'total' => (int) $total]);
    }

    public function actionView($slug)
    {
        $lang = $this->resolveLang();
        $menuId = Yii::$app->request->get('menuId', 71); // legacy hardcodes 71 at most call sites
        $post = Post::find()->where(['status' => 1, 'slug' => $slug])->one();
        if (!$post) {
            return $this->fail('NOT_FOUND', 'Yangilik topilmadi.', null, 404);
        }
        $post->updateCounters(['seen' => 1]);

        $file = $lang === 'ru' ? $post->file_ru : ($lang === 'en' ? $post->file_en : $post->file);

        // Note: string-key array unpacking (...$arr) needs PHP 8.1+; this
        // project targets PHP 7.4 (see composer.json / plan's XAMPP choice),
        // so array_merge is used instead.
        return $this->success(array_merge($this->mapPost($post, $lang), [
            'menuId' => (int) $menuId,
            'file' => $file ? $this->assetUrl($file) : null,
        ]));
    }

    private function mapPost($post, $lang)
    {
        return [
            'id' => (int) $post->id,
            'title' => $post->{'title_' . $lang},
            'content' => $this->assetUrlsInHtml($post->{'content_' . $lang}),
            'img' => $this->assetUrl($post->img),
            'slug' => $post->slug,
            'date' => $post->date,
            'seen' => (int) $post->seen,
            'category' => $post->category ? [
                'id' => (int) $post->category->id,
                'title' => $post->category->{'title_' . $lang},
                'slug' => $post->category->slug,
            ] : null,
        ];
    }
}
