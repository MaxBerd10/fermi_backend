<?php

namespace api\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Shared CRUD scaffold for every /v1/admin/* controller. Subclasses only need
 * to implement modelClass() (and optionally applyFilters()/scenario tweaks)
 * to get list/view/create/update/delete for free — kept as plain, explicit
 * methods (not yii\rest\ActiveController) so the response shape matches the
 * rest of api/'s hand-rolled {success,data,meta} envelope exactly.
 *
 * Every action here requires a valid JWT for a user with role='admin'
 * (common\models\User::isAdmin()) — the legacy backend/ AsosController only
 * ever checked roles=>['@'] (any authenticated user), which let any public
 * signup reach every CRUD screen; this is deliberately stricter.
 */
abstract class BaseAdminController extends BaseApiController
{
    /** @return string ActiveRecord class this controller manages */
    abstract protected function modelClass();

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
        $class = $this->modelClass();
        $query = $class::find();
        $this->applyFilters($query);

        $pageSize = min((int) Yii::$app->request->get('pageSize', 20), 100);
        $pagination = new Pagination([
            'totalCount' => (clone $query)->count(),
            'pageSize' => $pageSize,
            'page' => max(0, (int) Yii::$app->request->get('page', 1) - 1),
        ]);
        $models = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->success($models, [
            'page' => $pagination->page + 1,
            'pageSize' => $pagination->pageSize,
            'total' => $pagination->totalCount,
        ]);
    }

    public function actionView($id)
    {
        return $this->success($this->findModel($id));
    }

    public function actionCreate()
    {
        $class = $this->modelClass();
        $model = new $class();
        $model->load(Yii::$app->request->getBodyParams(), '');
        if (!$model->save()) {
            return $this->fail('VALIDATION_ERROR', 'Ma\'lumotlar noto\'g\'ri kiritilgan.', $model->errors, 422);
        }
        return $this->success($model);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->getBodyParams(), '');
        if (!$model->save()) {
            return $this->fail('VALIDATION_ERROR', 'Ma\'lumotlar noto\'g\'ri kiritilgan.', $model->errors, 422);
        }
        return $this->success($model);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->success(['deleted' => true]);
    }

    /**
     * Hook for subclasses to apply ?search=/?filter[x]= query constraints.
     * No-op by default.
     *
     * @param \yii\db\ActiveQuery $query
     */
    protected function applyFilters($query)
    {
    }

    /**
     * @param int $id
     * @return \yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $class = $this->modelClass();
        $model = $class::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Yozuv topilmadi.');
        }
        return $model;
    }
}
