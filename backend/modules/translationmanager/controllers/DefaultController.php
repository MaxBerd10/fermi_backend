<?php



namespace backend\modules\translationmanager\controllers;



use backend\modules\translationmanager\models\Message;
use yii\filters\AccessControl;

use Yii;

use backend\modules\translationmanager\models\SourceMessage;

use backend\modules\translationmanager\models\SourceMessageSearch;

use yii\web\Controller;

use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;



/**

 * DefaultController implements the CRUD actions for SourceMessage model.

 */

class DefaultController extends Controller

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


    /**

     * Lists all SourceMessage models.

     * @return mixed

     */

    public function actionIndex()

    {

        $searchModel = new SourceMessageSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [

            'searchModel' => $searchModel,

            'dataProvider' => $dataProvider,

        ]);

    }



    /**

     * Displays a single SourceMessage model.

     * @param integer $id

     * @return mixed

     */

    public function actionView($id)

    {

        return $this->render('view', [

            'model' => $this->findModel($id),

        ]);

    }



    /**

     * Creates a new SourceMessage model.

     * If creation is successful, the browser will be redirected to the 'view' page.

     * @return mixed

     */

    public function actionCreate()

    {

        $model = new SourceMessage([

            'category' => 'app',

        ]);



        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['index']);

        } else {

            return $this->render('create', [

                'model' => $model,

            ]);

        }

    }


    public function actionUpdate($id)

    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [

                'model' => $model,

            ]);

        }

    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);

    }

    protected function findModel($id)

    {
        if (($model = SourceMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*public function actionConvert()
    {
        $models = SourceMessage::find()->all();

        foreach ($models as $model){

            $kr = Message::findOne(['id' => $model->id, 'language' => 'kr']);
            if ($kr == null){
                $kr = new Message(['id' => $model->id, 'language' => 'kr']);
            }
            if ($kr->translation == ''){

                $uz = Message::findOne(['id' => $model->id, 'language' => 'uz']);
                if ($uz != null){
                    $kr->translation = LatinCyrillConvertor::latinToCyrill($uz->translation);
                    $kr->save();
                }

            }
        }

    }*/

}

