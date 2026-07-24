<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AcceptanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rahbariyat qauli';
$this->params['content'] = 1;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="false">Rahbariyat qabuliga yozilish</a></li>
        <li class="active"><a href="#tab_2" data-toggle="tab" aria-expanded="true">Rektor qabuliga yozilish</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane " id="tab_1">

            <?php \yii\widgets\Pjax::begin() ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //  'id',
                    // 'category_id',
                    [
                        'attribute' => 'category_id',
                        'label' => 'Rahbariyat',

                        'value' => function ($data) {
                            return $data->category->name;
                        },
                        'filter' => ArrayHelper::map(\backend\models\ConnectLeader::find()->all(), 'id', 'name'),
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'options' => ['prompt' => ''],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'width'=>'200px'
                            ],
                        ],
                    ],
                    'date',
                    'subject',
                    'fish',
                    //'status',
                    [
                        'attribute' => 'status',
                        'label' => 'status',
                        'value' => function(\backend\models\Acceptance $model)
                        {
                            return \backend\models\Acceptance::getstatus()[$model->status];
                        },
                        'filter' => \backend\models\Acceptance::getstatus(),
                    ],
                    'phone',
                    //'email:email',
                    //'region_id',

                    //'district_id',

                    //'quater_id',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php \yii\widgets\Pjax::end() ?>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane active" id="tab_2">

            <?php \yii\widgets\Pjax::begin() ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider2,
                'filterModel' => $searchModel2,
                'columns' => [
                    [
                        'class'=>\yii\grid\SerialColumn::class,
                        'contentOptions'=>function(\backend\models\Virtual $model){
                            $class='';
                            switch ($model->status)
                            {
                                case \backend\models\Virtual::STATUS_SHOWED:$class='alert-success';break;
                                case \backend\models\Virtual::STATUS_NOTSHOWED:$class='alert-danger';break;
                                default:$class='alert-info';
                            }
                            return['class'=>$class];
                        }
                    ],

                    'fish',
                    //  'province',
                    //'fog',
                    //'address',
                    'phone',
                    //'email:email',
                    //'gender',
                    //'faculty_id',
                    'text:ntext',
                    'file',
                    'created_at',
                    //'status',
                    [
                        'attribute' => 'status',
                        'label' => 'status',
                        'value' => function(\backend\models\Virtual $model)
                        {
                            return \backend\models\Virtual::getstatus()[$model->status];
                        },
                        'filter' => \backend\models\Virtual::getstatus(),
                    ],
                    ['class' => 'yii\grid\ActionColumn','template'=>'{view}  {delete} {mark}',
                        'buttons'=>[
                            'mark'=>function($url,$model,$key)
                            {
                                if ($model->status==1){
                                    return Html::a('<span class="glyphicon glyphicon-ok btn btn-success"></span>',['acceptance/mark2', 'id'=>$model->id]);
                                }
                                else
                                {
                                    return Html::a('<span class="glyphicon glyphicon-ok btn btn-danger"></span>', ['acceptance/mark2', 'id'=>$model->id]);
                                }
                            },
                            'view'=>function($url,$model,$key){
                                return Html::a('<span class="glyphicon glyphicon-eye-open btn btn-info"></span>',['acceptance/view2', 'id'=>$model->id]);
                            },
                            'delete'=>function($url,$model,$key){
                                return Html::a('<span class="glyphicon glyphicon-trash btn btn-danger"></span>',['virtual/delete', 'id'=>$model->id], ['data-method'=>"POST"]);
                            }
                        ],


                    ],

                ],
            ]); ?>

            <?php \yii\widgets\Pjax::end() ?>
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>