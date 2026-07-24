<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = "Yangilik qo'shish";
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['index'] = Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px"></span>', ['page/index'],['style'=>'margin-left:10px']); ?>
<?php $this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
