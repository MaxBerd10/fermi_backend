<?php

namespace backend\controllers;

use mihaildev\elfinder\Controller;

class ElfinderController extends Controller
{
    public $disabledCommands = ['netmount'];

    public function beforeAction($action)
    {
        // Adjust the maximum file size here (e.g., 10 MB)
        $this->getManagerOptions(['uploadAllow' => ['image/*'], 'uploadMaxSize' => '1M']);

        return parent::beforeAction($action);
    }
}
