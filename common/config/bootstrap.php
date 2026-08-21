<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');

// Telegram webhook .env loader (server-only secrets)
$__envFile = dirname(__DIR__, 2) . '/.env';
if (is_readable($__envFile)) {
    foreach (file($__envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $__line) {
        $__line = trim($__line);
        if ($__line === '' || $__line[0] === '#' || strpos($__line, '=') === false) {
            continue;
        }
        list($__k, $__v) = explode('=', $__line, 2);
        $__k = trim($__k);
        $__v = trim($__v, " \t\"'");
        if ($__k !== '' && getenv($__k) === false) {
            putenv($__k . '=' . $__v);
            $_ENV[$__k] = $__v;
            $_SERVER[$__k] = $__v;
        }
    }
}
unset($__envFile, $__line, $__k, $__v);

