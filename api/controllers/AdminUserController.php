<?php

namespace api\controllers;

use Yii;
use common\models\User;
use yii\data\Pagination;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * /v1/admin/users — account + role management. Deliberately NOT a
 * BaseAdminController subclass: that generic CRUD returns raw ActiveRecord
 * attributes, which for User would leak password_hash/auth_key/refresh_token/
 * *_token columns straight into the admin API response. Every action here
 * whitelists exactly the safe fields instead.
 */
class AdminUserController extends BaseApiController
{
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
        $query = User::find()->orderBy(['id' => SORT_DESC]);
        $search = Yii::$app->request->get('search');
        if ($search) {
            $query->andWhere(['or',
                ['like', 'username', $search],
                ['like', 'email', $search],
            ]);
        }

        $pageSize = min((int) Yii::$app->request->get('pageSize', 20), 100);
        $pagination = new Pagination([
            'totalCount' => (clone $query)->count(),
            'pageSize' => $pageSize,
            'page' => max(0, (int) Yii::$app->request->get('page', 1) - 1),
        ]);
        $users = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->success(array_map([$this, 'userToArray'], $users), [
            'page' => $pagination->page + 1,
            'pageSize' => $pagination->pageSize,
            'total' => $pagination->totalCount,
        ]);
    }

    public function actionView($id)
    {
        return $this->success($this->userToArray($this->findUser($id)));
    }

    public function actionCreate()
    {
        $body = Yii::$app->request->getBodyParams();
        $user = new User();
        $user->username = $body['username'] ?? null;
        $user->email = $body['email'] ?? null;
        $user->status = isset($body['status']) ? (int) $body['status'] : User::STATUS_ACTIVE;
        $user->role = ($body['role'] ?? 'user') === 'admin' ? 'admin' : 'user';
        $user->type = 0;
        $user->generateAuthKey();

        if (empty($body['password'])) {
            return $this->fail('VALIDATION_ERROR', 'Parol kiritilishi shart.', ['password' => ['Parol kiritilishi shart.']], 422);
        }
        $user->setPassword($body['password']);

        if (!$user->save()) {
            return $this->fail('VALIDATION_ERROR', 'Ma\'lumotlar noto\'g\'ri kiritilgan.', $user->errors, 422);
        }
        return $this->success($this->userToArray($user));
    }

    public function actionUpdate($id)
    {
        $user = $this->findUser($id);
        $body = Yii::$app->request->getBodyParams();

        if (array_key_exists('username', $body)) {
            $user->username = $body['username'];
        }
        if (array_key_exists('email', $body)) {
            $user->email = $body['email'];
        }
        if (array_key_exists('status', $body)) {
            $user->status = (int) $body['status'];
        }
        if (array_key_exists('role', $body)) {
            $this->guardLastAdmin($user, $body['role']);
            $user->role = $body['role'] === 'admin' ? 'admin' : 'user';
        }
        if (!empty($body['password'])) {
            $user->setPassword($body['password']);
        }

        if (!$user->save()) {
            return $this->fail('VALIDATION_ERROR', 'Ma\'lumotlar noto\'g\'ri kiritilgan.', $user->errors, 422);
        }
        return $this->success($this->userToArray($user));
    }

    public function actionDelete($id)
    {
        $user = $this->findUser($id);
        $identity = Yii::$app->user->identity;
        if ((int) $user->id === (int) $identity->id) {
            return $this->fail('CANNOT_DELETE_SELF', 'O\'zingizning hisobingizni o\'chira olmaysiz.', null, 422);
        }
        $this->guardLastAdmin($user, 'user');
        $user->delete();
        return $this->success(['deleted' => true]);
    }

    /**
     * Refuses to demote/delete the last remaining admin account, so the
     * panel can never lock every admin out of itself.
     *
     * @param User $user
     * @param string $newRole
     * @throws \yii\web\UnprocessableEntityHttpException caught by Yii's error
     *   handler and normalized into the standard {success:false,error} shape
     *   by api/config/main.php's response->on('beforeSend', ...) handler.
     */
    private function guardLastAdmin(User $user, $newRole)
    {
        if ($user->role === 'admin' && $newRole !== 'admin') {
            $otherAdmins = User::find()->where(['role' => 'admin'])->andWhere(['!=', 'id', $user->id])->count();
            if ((int) $otherAdmins === 0) {
                throw new \yii\web\UnprocessableEntityHttpException('Kamida bitta administrator qolishi kerak.');
            }
        }
    }

    /**
     * @param int $id
     * @return User
     */
    private function findUser($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('Foydalanuvchi topilmadi.');
        }
        return $user;
    }

    private function userToArray(User $user)
    {
        return [
            'id' => (int) $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'status' => (int) $user->status,
            'role' => $user->role,
            'createdAt' => $user->created_at ? date('Y-m-d H:i', $user->created_at) : null,
        ];
    }
}
