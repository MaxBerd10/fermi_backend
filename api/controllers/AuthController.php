<?php

namespace api\controllers;

use Yii;
use common\models\User;
use common\models\LoginForm;
use frontend\models\SignupForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\VerifyEmailForm;
use frontend\models\ResendVerificationEmailForm;
use yii\base\InvalidArgumentException;
use yii\filters\auth\HttpBearerAuth;
use yii\web\BadRequestHttpException;

/**
 * Token-based (JWT) auth for the React SPA, wrapping the same form models the
 * legacy session-based frontend\controllers\SiteController uses (SignupForm,
 * LoginForm, PasswordResetRequestForm, ResetPasswordForm, VerifyEmailForm,
 * ResendVerificationEmailForm) so validation/email-sending logic isn't duplicated.
 *
 * Unlike the legacy site, login here never touches Yii::$app->user's
 * session/cookie — the api/ app runs with 'user'=>['enableSession'=>false],
 * so identity is entirely carried by the JWT the client sends as
 * `Authorization: Bearer <token>`.
 */
class AuthController extends BaseApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['me', 'logout'],
        ];
        return $behaviors;
    }

    public function verbs()
    {
        return [
            'register' => ['POST'],
            'login' => ['POST'],
            'refresh' => ['POST'],
            'logout' => ['POST'],
            'me' => ['GET'],
            'password-reset-request' => ['POST'],
            'password-reset' => ['POST'],
            'verify-email' => ['POST'],
            'resend-verification' => ['POST'],
        ];
    }

    public function actionRegister()
    {
        $form = new SignupForm();
        $form->load(Yii::$app->request->post(), '');
        if (!$form->validate()) {
            return $this->fail('VALIDATION_ERROR', 'Ma\'lumotlar noto\'g\'ri kiritilgan.', $form->errors, 422);
        }
        if (!$form->signup()) {
            return $this->fail('SIGNUP_FAILED', 'Ro\'yxatdan o\'tishda xatolik yuz berdi.', null, 500);
        }
        $user = User::findByUsername($form->username);
        return $this->issueTokens($user);
    }

    public function actionLogin()
    {
        $form = new LoginForm();
        $form->load(Yii::$app->request->post(), '');
        if (!$form->validate()) {
            return $this->fail('INVALID_CREDENTIALS', 'Login yoki parol noto\'g\'ri.', $form->errors, 401);
        }
        $user = User::findByUsername($form->username);
        return $this->issueTokens($user);
    }

    public function actionRefresh()
    {
        $refreshToken = Yii::$app->request->post('refreshToken');
        $user = User::findByRefreshToken($refreshToken);
        if (!$user) {
            return $this->fail('INVALID_REFRESH_TOKEN', 'Refresh token yaroqsiz yoki muddati o\'tgan.', null, 401);
        }
        return $this->issueTokens($user);
    }

    public function actionLogout()
    {
        $user = Yii::$app->user->identity;
        $user->refresh_token = null;
        $user->save(false, ['refresh_token']);
        return $this->success(['loggedOut' => true]);
    }

    public function actionMe()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        return $this->success($this->userToArray($user));
    }

    public function actionPasswordResetRequest()
    {
        $form = new PasswordResetRequestForm();
        $form->load(Yii::$app->request->post(), '');
        if (!$form->validate()) {
            return $this->fail('VALIDATION_ERROR', 'Email topilmadi.', $form->errors, 422);
        }
        $form->sendEmail();
        return $this->success(['sent' => true]);
    }

    public function actionPasswordReset()
    {
        $token = Yii::$app->request->post('token');
        try {
            $form = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        $form->load(Yii::$app->request->post(), '');
        if (!$form->validate()) {
            return $this->fail('VALIDATION_ERROR', 'Parol talablarga mos emas.', $form->errors, 422);
        }
        if (!$form->resetPassword()) {
            return $this->fail('RESET_FAILED', 'Parolni tiklashda xatolik yuz berdi.', null, 500);
        }
        return $this->success(['reset' => true]);
    }

    public function actionVerifyEmail()
    {
        $token = Yii::$app->request->post('token');
        try {
            $form = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        $user = $form->verifyEmail();
        if (!$user) {
            return $this->fail('VERIFY_FAILED', 'Emailni tasdiqlashda xatolik yuz berdi.', null, 500);
        }
        return $this->issueTokens($user);
    }

    public function actionResendVerification()
    {
        $form = new ResendVerificationEmailForm();
        $form->load(Yii::$app->request->post(), '');
        if (!$form->validate()) {
            return $this->fail('VALIDATION_ERROR', 'Email topilmadi.', $form->errors, 422);
        }
        $form->sendEmail();
        return $this->success(['sent' => true]);
    }

    /**
     * @param User|null $user
     * @return array
     */
    private function issueTokens($user)
    {
        if (!$user) {
            return $this->fail('NOT_FOUND', 'Foydalanuvchi topilmadi.', null, 404);
        }
        $user->generateRefreshToken();
        $user->save(false, ['refresh_token']);
        return $this->success([
            'accessToken' => $user->generateJwt(),
            'refreshToken' => $user->refresh_token,
            'user' => $this->userToArray($user),
        ]);
    }

    /**
     * @param User $user
     * @return array
     */
    private function userToArray($user)
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'status' => $user->status,
            'role' => $user->role,
        ];
    }
}
