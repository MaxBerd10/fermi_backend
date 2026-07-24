<?php


use kartik\grid\GridView;

$this->title = Yii::t('app',  'Translations');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="">
    <div class="">
        <a href="<?= \yii\helpers\Url::to(['create']) ?>" class="btn btn-success">
            <?= ('Create new') ?>
        </a>
        <br><br>
        <div class="">
            <div class="">
                <span class="label label-default">записей <?= $dataProvider->getCount() ?> из <?= $dataProvider->getTotalCount() ?></span>
            </div>

            <div class="">

                <?= GridView::widget([
                    'pjax' => true,
                    'panel' => [
                        'type' => 'success',
                        'heading' => $this->title,
                    ],
                    'summary' => '',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => Yii::$app->getModule('translate-manager')->getGridColumns($searchModel),
                ]); ?>

            </div>

        </div>

    </div>

</div>

