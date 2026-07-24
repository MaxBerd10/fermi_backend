<?php

namespace backend\controllers;

use backend\models\Post;
use Yii;
use backend\models\Corusel;
use backend\models\CoruselSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CoruselController implements the CRUD actions for Corusel model.
 */
class CoruselController extends AsosController
{
    /**
     * {@inheritdoc}
     */
    /**
     * Lists all Corusel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoruselSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Corusel model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Corusel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Corusel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Corusel model.
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
     * Deletes an existing Corusel model.
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
     * Finds the Corusel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Corusel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionMark($id)
    {
        $post=Corusel::find()->where(['id'=>$id])->one();
        if (Corusel::STATUS_SHOWED==$post->status){
            $post->status=Corusel::STATUS_NOTSHOWED;
        }
        else{
            $post->status=Corusel::STATUS_SHOWED;
        }
        $post->save();
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Corusel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
