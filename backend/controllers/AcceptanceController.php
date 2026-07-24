<?php

namespace backend\controllers;

use backend\models\Virtual;
use backend\models\VirtualSearch;
use Yii;
use backend\models\Acceptance;
use backend\models\AcceptanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AcceptanceController implements the CRUD actions for Acceptance model.
 */
class AcceptanceController extends AsosController
{
    /**
     * {@inheritdoc}
     */


    /**
     * Lists all Acceptance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AcceptanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel2 = new VirtualSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);
    }
    public function actionIndex2()
    {
        $searchModel = new AcceptanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel2 = new VirtualSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);

        return $this->render('index2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);
    }
    /**
     * Displays a single Acceptance model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view',
            [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionView2($id)
    {
        return $this->render('view2',
            [
                'model' => $this->findModel2($id),
            ]);
    }

    /**
     * Creates a new Acceptance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Acceptance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Acceptance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Acceptance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Acceptance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Acceptance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Acceptance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModel2($id)
    {
        if (($model = Virtual::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionMark2($id)
    {
        $virtual=Virtual::find()->where(['id'=>$id])->one();
        if (Virtual::STATUS_SHOWED==$virtual->status){
            $virtual->status=Virtual::STATUS_NOTSHOWED;
        }
        else{
            $virtual->status=Virtual::STATUS_SHOWED;
        }
        $virtual->save();
        return $this->redirect(['index2']);
    }
}
