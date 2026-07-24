<?php

namespace api\controllers;

use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * /v1/admin/translations — CRUD over the legacy Yii2 DbMessageSource tables
 * (source_message + message), replacing backend/modules/translationmanager's
 * admin screen. These back every Yii::t('app', ...) call across the site's
 * UI chrome (button labels, static headings, etc.) — distinct from the CMS
 * content_uz/ru/en columns the rest of api/admin/* manages.
 */
class AdminTranslationController extends BaseApiController
{
    private const LANGS = ['uz', 'ru', 'en'];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['options'],
        ];
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if ($action->id === 'options') {
            return true;
        }
        $identity = Yii::$app->user->identity;
        if (!$identity || !$identity->isAdmin()) {
            throw new ForbiddenHttpException('Bu amal uchun administrator huquqi kerak.');
        }
        return true;
    }

    public function actionIndex()
    {
        $query = (new Query())->from('source_message');
        $search = Yii::$app->request->get('search');
        if ($search) {
            $query->andWhere(['or', ['like', 'message', $search], ['like', 'category', $search]]);
        }

        $pageSize = min((int) Yii::$app->request->get('pageSize', 20), 100);
        $pagination = new Pagination([
            'totalCount' => (clone $query)->count(),
            'pageSize' => $pageSize,
            'page' => max(0, (int) Yii::$app->request->get('page', 1) - 1),
        ]);
        $rows = $query->orderBy(['id' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();

        $ids = array_column($rows, 'id');
        $translations = $this->translationsFor($ids);

        return $this->success(array_map(function ($row) use ($translations) {
            return $this->rowToArray($row, $translations[$row['id']] ?? []);
        }, $rows), [
            'page' => $pagination->page + 1,
            'pageSize' => $pagination->pageSize,
            'total' => $pagination->totalCount,
        ]);
    }

    public function actionView($id)
    {
        $row = $this->findRow($id);
        $translations = $this->translationsFor([$id]);
        return $this->success($this->rowToArray($row, $translations[$id] ?? []));
    }

    public function actionCreate()
    {
        $body = Yii::$app->request->getBodyParams();
        if (empty($body['message'])) {
            return $this->fail('VALIDATION_ERROR', 'Matn (key) kiritilishi shart.', ['message' => ['Matn kiritilishi shart.']], 422);
        }

        Yii::$app->db->createCommand()->insert('source_message', [
            'category' => $body['category'] ?? 'app',
            'message' => $body['message'],
        ])->execute();
        $id = (int) Yii::$app->db->getLastInsertID();

        $this->saveTranslations($id, $body);

        $row = $this->findRow($id);
        $translations = $this->translationsFor([$id]);
        return $this->success($this->rowToArray($row, $translations[$id] ?? []));
    }

    public function actionUpdate($id)
    {
        $row = $this->findRow($id);
        $body = Yii::$app->request->getBodyParams();

        $updates = [];
        if (array_key_exists('category', $body)) {
            $updates['category'] = $body['category'];
        }
        if (array_key_exists('message', $body)) {
            $updates['message'] = $body['message'];
        }
        if ($updates) {
            Yii::$app->db->createCommand()->update('source_message', $updates, ['id' => $id])->execute();
        }

        $this->saveTranslations((int) $id, $body);

        $row = $this->findRow($id);
        $translations = $this->translationsFor([$id]);
        return $this->success($this->rowToArray($row, $translations[$id] ?? []));
    }

    public function actionDelete($id)
    {
        $this->findRow($id);
        // message rows cascade-delete via the FK's ON DELETE CASCADE.
        Yii::$app->db->createCommand()->delete('source_message', ['id' => $id])->execute();
        return $this->success(['deleted' => true]);
    }

    private function saveTranslations($id, array $body)
    {
        foreach (self::LANGS as $lang) {
            $key = "translation_{$lang}";
            if (!array_key_exists($key, $body)) {
                continue;
            }
            $value = $body[$key] === '' ? null : $body[$key];
            $exists = (new Query())->from('message')->where(['id' => $id, 'language' => $lang])->exists();
            if ($exists) {
                Yii::$app->db->createCommand()->update('message', ['translation' => $value], ['id' => $id, 'language' => $lang])->execute();
            } else {
                Yii::$app->db->createCommand()->insert('message', ['id' => $id, 'language' => $lang, 'translation' => $value])->execute();
            }
        }
    }

    /**
     * @param int[] $ids
     * @return array<int, array<string,string|null>> id => {lang => translation}
     */
    private function translationsFor(array $ids)
    {
        if (empty($ids)) {
            return [];
        }
        $rows = (new Query())->from('message')->where(['id' => $ids])->all();
        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row['id']][$row['language']] = $row['translation'];
        }
        return $map;
    }

    private function findRow($id)
    {
        $row = (new Query())->from('source_message')->where(['id' => $id])->one();
        if (!$row) {
            throw new NotFoundHttpException('Tarjima topilmadi.');
        }
        return $row;
    }

    private function rowToArray($row, array $translations)
    {
        return [
            'id' => (int) $row['id'],
            'category' => $row['category'],
            'message' => $row['message'],
            'translation_uz' => $translations['uz'] ?? null,
            'translation_ru' => $translations['ru'] ?? null,
            'translation_en' => $translations['en'] ?? null,
        ];
    }
}
