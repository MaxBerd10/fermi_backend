<?php

namespace api\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

/**
 * /v1/admin/media/upload — single-file upload used by the React admin's
 * image/file picker on every content form (Page/Post/Faculty/... img & file
 * fields). Saves into frontend/web/uploads/img/admin/<Y>/<Ym>/ (same physical
 * docroot the legacy site's uploads already live under, so assetUrl() in
 * BaseApiController resolves the returned path identically to every other
 * media field) and returns the root-relative path to store in the DB column.
 */
class AdminMediaController extends BaseApiController
{
    private const ALLOWED_EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

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

    private const IMAGE_EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'JPG', 'JPEG', 'PNG'];

    /**
     * GET /v1/admin/media/list?path=<relative-to-uploads/img>
     * Browses the whole uploads/img tree (not just the admin/ subfolder), so
     * an editor can reuse legacy files too, not only ones freshly uploaded
     * through this panel. `path` is validated to resolve within uploads/img
     * via realpath() so `../../` can't escape the docroot.
     */
    public function actionList()
    {
        $root = realpath(Yii::getAlias('@frontend/web/uploads/img'));
        $requested = (string) Yii::$app->request->get('path', '');
        $target = realpath($root . '/' . ltrim($requested, '/'));

        if ($target === false || strpos($target, $root) !== 0 || !is_dir($target)) {
            return $this->fail('INVALID_PATH', 'Noto\'g\'ri manzil.', null, 422);
        }

        $relativeBase = trim(str_replace('\\', '/', substr($target, strlen($root))), '/');
        $folders = [];
        $files = [];

        foreach (scandir($target) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $fullPath = $target . DIRECTORY_SEPARATOR . $entry;
            $entryRelative = ($relativeBase === '' ? '' : $relativeBase . '/') . $entry;

            if (is_dir($fullPath)) {
                $folders[] = ['name' => $entry, 'path' => $entryRelative];
                continue;
            }

            $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
            $urlPath = '/uploads/img/' . $entryRelative;
            $files[] = [
                'name' => $entry,
                'path' => $urlPath,
                'url' => $this->assetUrl($urlPath),
                'size' => filesize($fullPath),
                'isImage' => in_array($ext, self::IMAGE_EXT, true),
            ];
        }

        usort($folders, function ($a, $b) { return strcasecmp($a['name'], $b['name']); });
        usort($files, function ($a, $b) { return strcasecmp($a['name'], $b['name']); });

        $parentPath = null;
        if ($relativeBase !== '') {
            $parts = explode('/', $relativeBase);
            array_pop($parts);
            $parentPath = implode('/', $parts);
        }

        return $this->success([
            'currentPath' => $relativeBase,
            'parentPath' => $parentPath,
            'folders' => $folders,
            'files' => $files,
        ]);
    }

    public function actionUpload()
    {
        $file = UploadedFile::getInstanceByName('file');
        if (!$file) {
            return $this->fail('NO_FILE', 'Fayl yuborilmadi.', null, 400);
        }
        $ext = strtolower($file->extension);
        if (!in_array($ext, self::ALLOWED_EXT, true)) {
            return $this->fail('INVALID_TYPE', 'Fayl turi qo\'llab-quvvatlanmaydi: .' . $ext, null, 422);
        }

        $subDir = date('Y') . '/' . date('m') . '/';
        $dir = Yii::getAlias('@frontend/web/uploads/img/admin/') . $subDir;
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $safeName = Yii::$app->security->generateRandomString(8) . '-' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->baseName) . '.' . $ext;
        $file->saveAs($dir . $safeName);

        $relativePath = '/uploads/img/admin/' . $subDir . $safeName;
        return $this->success([
            'path' => $relativePath,
            'url' => $this->assetUrl($relativePath),
        ]);
    }
}
