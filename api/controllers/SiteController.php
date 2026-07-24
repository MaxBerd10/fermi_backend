<?php

namespace api\controllers;

/**
 * Health-check endpoint: GET /v1/site/ping — used to verify the api/ app is
 * wired up (vhost, bootstrap, urlManager rules) before building real endpoints.
 */
class SiteController extends BaseApiController
{
    public function actionPing()
    {
        return $this->success(['pong' => true, 'time' => date('c')]);
    }
}
