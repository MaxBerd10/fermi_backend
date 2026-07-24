<?php
namespace backend\modules\menumanager\controllers;
use backend\controllers\BackendController;
use backend\models\Departments;
use backend\models\Documents;
use backend\models\Faculty;
use backend\models\Leader;
use backend\models\Leadercategory;
use backend\models\Page;
use backend\models\Postcategory;
use Yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
class MenuController extends Controller
{
      public function actions()
    {
        return[
            'error'=>[
                'class'=>'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                     [
                        'actions'=>['login','error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionGetValue()
    {

        $options = '';
        $type = $_GET['type'];
        if ($type == 'category') {
            $options = $this->categories();
        }
        if ($type == 'leader') {
            $options = $this->leaders();
        }
        if ($type == 'page') {
            $options = $this->pages();
        }

        if ($type == 'documents') {
            $options = $this->documents();
        }
        if ($type == 'faculty') {
            $options = $this->faculties();
        }

        if ($type == 'c-action') {
            $options = $this->sections();
        }
        if ($type == 'departments') {
            $options = $this->departments();
        }


        return Html::tag('select', $options, [
            'id' => 'tree-url_value',
            'class' => 'form-control',
            'name' => 'Menu[url_value]'
        ]);

    }

    private function categories()
    {

        $categories = Postcategory::find()->all();
        $options = Html::tag('option', "Kategoriyani tanlang");
        foreach ($categories as $category) {
            $options .= Html::tag('option', $category->title_uz, ['value' => $category->slug]);
        }

        return $options;
    }
    private function leaders()
    {

        $categories = Leadercategory::find()->all();
        $options = Html::tag('option', "Kategoriyani tanlang");
        foreach ($categories as $category) {
            $options .= Html::tag('option', $category->title_uz, ['value' => $category->slug]);
        }
        return $options;
    }
    private function departments()
    {

        $categories = Departments::find()->all();
        $options = Html::tag('option', "Kategoriyani tanlang");
        foreach ($categories as $category) {
            $options .= Html::tag('option', $category->title_uz, ['value' => $category->slug]);
        }
        return $options;
    }
    private function pages()
    {
        $pages = Page::find()->all();
        $options = Html::tag('option', "Sahifani tanlang");
        foreach ($pages as $page) {
            $options .= Html::tag('option', $page->slug, ['value' => $page->slug]);
        }
        return $options;
    }

    private function documents()
    {
        $pages = Documents::find()->all();
        $options = Html::tag('option', "Sahifani tanlang");
        foreach ($pages as $page) {
            $options .= Html::tag('option', $page->title_uz, ['value' => $page->slug]);
        }
        return $options;
    }
    private function faculties()
    {
        $faculites=Faculty::find()->all();
        $options = Html::tag('option', "Sahifani tanlang");
        foreach ($faculites as $faculty) {
            $options .= Html::tag('option', $faculty->title_uz, ['value' => $faculty->slug]);
        }
        return $options;
    }


    private function sections()
    {
        $sections = Yii::$app->getModule('menumanager')->sections();
        $options = Html::tag('option', "Sahifani tanlang ... ");
        foreach ($sections as $route => $label) {
            $options .= Html::tag('option', $label, ['value' => $route]);
        }
        return $options;
    }

}