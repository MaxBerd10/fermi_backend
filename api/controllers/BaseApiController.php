<?php

namespace api\controllers;

use Yii;
use yii\filters\Cors;
use yii\web\Controller;
use yii\web\Response;

/**
 * Base controller for every api/ endpoint: JSON-only, CSRF-free, CORS-enabled,
 * and provides success()/fail() helpers producing the standard
 * {success,data,meta} / {success:false,error:{code,message,fields}} envelope
 * (final shaping/normalization for exception-thrown errors happens in
 * api/config/main.php's response->on('beforeSend', ...)).
 */
class BaseApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => Yii::$app->params['cors.allowedOrigins'] ?? ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 3600,
            ],
        ];
        return $behaviors;
    }

    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    /**
     * Every admin/* URL rule is verb-restricted (e.g. 'GET v1/admin/news'),
     * which only matches that exact HTTP method — a CORS preflight OPTIONS
     * request wouldn't match any of them, so urlManager would 404 it before
     * the Cors behavior ever got a chance to answer it (see the catch-all
     * 'OPTIONS v1/admin/<...>' rule in config/main.php that routes here).
     * In practice the Cors filter's own beforeAction already terminates
     * real preflight requests earlier in the behavior chain; this action
     * body only runs for the rare case that doesn't happen.
     */
    public function actionOptions()
    {
        return $this->success(null);
    }

    /**
     * @param mixed $data
     * @param array|null $meta
     * @return array
     */
    protected function success($data, $meta = null)
    {
        $envelope = ['success' => true, 'data' => $data];
        if ($meta !== null) {
            $envelope['meta'] = $meta;
        }
        return $envelope;
    }

    /**
     * @param string $code
     * @param string $message
     * @param array|null $fields validation errors, e.g. Model::errors
     * @param int $statusCode HTTP status to set on the response
     * @return array
     */
    protected function fail($code, $message, $fields = null, $statusCode = 400)
    {
        Yii::$app->response->statusCode = $statusCode;
        $error = ['code' => $code, 'message' => $message];
        if ($fields !== null) {
            $error['fields'] = $fields;
        }
        return ['success' => false, 'error' => $error];
    }

    /**
     * Resolves the requested content language from ?lang=, defaulting to 'uz'
     * (mirrors the legacy session-based default in frontend\controllers\SiteController::init()).
     *
     * @return string one of 'uz'|'ru'|'en'
     */
    protected function resolveLang()
    {
        $lang = Yii::$app->request->get('lang', 'uz');
        return in_array($lang, ['uz', 'ru', 'en'], true) ? $lang : 'uz';
    }

    /**
     * DB-stored media paths (Post.img, Faculty.img, Leader.rasm, Video.video,
     * Logo.img, etc.) are root-relative (e.g. "/uploads/img/..."), meant to be
     * resolved against whichever origin serves frontend/web (the legacy PHP
     * site's docroot — that's where the actual files live, untouched by this
     * migration). The React SPA runs on a different origin in dev (and
     * possibly in prod too, depending on deployment), so these need
     * qualifying into absolute URLs here rather than left for the client to
     * guess at. Returns null/empty/already-absolute values unchanged.
     *
     * @param string|null $path
     * @return string|null
     */
    protected function assetUrl($path)
    {
        if (empty($path)) {
            return $path;
        }
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }
        $base = rtrim(Yii::$app->params['assets.baseUrl'] ?? '', '/');
        return $base . '/' . ltrim($path, '/');
    }

    /**
     * CKEditor-authored HTML (Page/Faculty/Departments/Post/About/Leader
     * activity+biography/DocumentsItem `content_*` columns) embeds its own
     * <img src="..."> / file <a href="..."> pointing at the same root-relative
     * "/uploads/..." paths as the dedicated img/photo/file columns — assetUrl()
     * alone doesn't touch these since they're inside a content blob, not a
     * separate field. Every such reference needs the same absolute-URL
     * qualification or the images/links inside rendered content are broken.
     *
     * @param string|null $html
     * @return string|null
     */
    protected function assetUrlsInHtml($html)
    {
        if (empty($html)) {
            return $html;
        }
        $base = rtrim(Yii::$app->params['assets.baseUrl'] ?? '', '/');
        if ($base === '') {
            return $html;
        }
        return preg_replace_callback(
            '#(src|href)=("|\')(/(?!/)[^"\']*)\2#i',
            function ($m) use ($base) {
                return $m[1] . '=' . $m[2] . $base . $m[3] . $m[2];
            },
            $html
        );
    }
}
