    <?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Postcategory */

$this->title = "Yangilik turi ";
$this->params['breadcrumbs'][] = ['label' => 'Postcategories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="box box-default">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="postcategory-create">
                        <?= $this->render('_form', [
                            'model' => $model,
                        ]) ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
