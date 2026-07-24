<?php



namespace backend\modules\translationmanager;



use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**

 * translation module definition class

 */

class TranslationManager extends \yii\base\Module

{

  /**
   * @var array Array of languages
   */

    public $languages = ['uz', 'ru', 'en'];

    public $grid_column = [];

    /**
     * @inheritdoc
     */

    public $controllerNamespace = 'backend\modules\translationmanager\controllers';

    /**
     * @inheritdoc
     */

    public function init()

    {
        parent::init();
        $this->grid_column = $this->getGridColumns();
    }

  /**
   * @return array Return array of column for gridViewWidget
   */

    public function getGridColumns(){

        $columns = [
            ['class' => 'yii\grid\SerialColumn'],
//            'category',
            'message:ntext'
        ];

        foreach ($this->languages as $one){
            $columns[] = [
                'label' => Yii::t('app',  $one),
                'value' => 'languages.'.$one,
                'filter' => '<input type="text" value="'.$_GET['SourceMessageSearch']['languages'][$one].'" class="form-control" name="SourceMessageSearch[languages]['.$one.']">',
            ];
        }

        $columns[] = [
            'class' => 'kartik\grid\ActionColumn',
            'width' => "150px",
            'viewOptions' => ['class' => 'btn btn-xs btn-outline-info'],
            'updateOptions' => ['class' => 'btn btn-xs btn-outline-success'],
            'deleteOptions' => ['class' => 'btn btn-xs btn-outline-danger'],

        ];
        return $columns;
    }
}

