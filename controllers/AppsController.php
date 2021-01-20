<?php

namespace app\controllers;

use Yii;
use app\models\Apps;
use app\models\AppsSearch;
use yii\web\Response;
use app\models\Util;
use app\models\FileManager;
use app\models\User;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl ;
use yii\web\UploadedFile;

/**
 * AppsController implements the CRUD actions for Apps model.
 */
class AppsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        Yii::$app->params['sesionApp']['userId']=Yii::$app->user->identity->id;
        Yii::$app->params['sesionApp']['userName']=isset(Yii::$app->user->identity->nombre)?Yii::$app->user->identity->nombre:Yii::$app->user->identity->username ;

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'index'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['about'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $valid_roles = [User::ROLE_ADMIN, User::ROLE_SUPERUSER];
                            return User::roleInArray($valid_roles) && User::isActive();
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Apps models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modelf = new UploadForm();
         //Obtener las Aplicaciones que tiene el usuario
       // $searchModel = new AppsSearch();
       // $searchModel->idUser=Yii::$app->user->getId();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       $idUser=Yii::$app->user->getId();
       $query = Apps::find();

       //Condiciones de usuario
       $rolUser=Yii::$app->user->identity->role;
       //Catidad de Aplicaciones disponible
       $cantApps=1;  

       // revisar!!!!
       $query->leftJoin('invitado', 'apps.idApp = invitado.app_idApp');
       

        $dataProvider = new ActiveDataProvider([
            'query' => $query->andWhere("apps.idUser=$idUser or invitado.idInvitado=$idUser"),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'userRol'=>$rolUser,
            'cantApps'=>$cantApps,
            'modelf'=>$modelf
        ]);
    }

     /**
     * Lists all los usuarios de la app.
     * @return mixed
     */
    public function actionUser($idApp)
    {
       $idUser=Yii::$app->user->getId();
       $query = Apps::find();


       //Obtener los usuarios en como data provider 
       //[{}]
       $appUsers=$this->findModel($idApp)->getInvitados();

        /**TODO
         * ----
         */
      

        return $this->render('users', [
            'users'=>$appUsers,
            'idApp'=>$idApp
             ]);
    }




    /**
     * Muesta la pantalla inicial de una aplicacion
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        /**
         * Renderisa la pantalla inicial de la App
         */
          //Identificar el tipo de app
          $app=$this->findModel($id);
          $role=User::getRole($id);

        // Definimos el parametro global para una sesion de la Aplicacion
        Yii::$app->params['sesionApp']['idApp']=$id;
        Yii::$app->params['sesionApp']['nameApp']=$app->nombre;
        Yii::$app->params['sesionApp']['typeApp']=$app->codigoApp;
        Yii::$app->params['sesionApp']['userId']=Yii::$app->user->identity->id;
        Yii::$app->params['sesionApp']['userName']=isset(Yii::$app->user->identity->nombre)?Yii::$app->user->identity->nombre:Yii::$app->user->identity->username ;
        Yii::$app->params['sesionApp']['userRole']=$role;
        $this->layout = 'layout_app';
        //-----------------------
        
        return $this->render('view', [
            'model' => $app,
        ]);
    }


    /**
     * Creates a new Apps model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        // si el operador el anónimo lo envia al login
        if (Yii::$app->user->isGuest){
            return $this->redirect(["site/login"]);
        }
        //--------------------------------------------

        $model = new Apps();
        $model->idUser= Yii::$app->user->getId();
        $model->idApp=Util::keyTime(); // creamos una key
       

        if ($model->load(Yii::$app->request->post()) ) {

            // insertar la fecha de inicio
            $model->fechaIni=date('Y-m-d H:i:s');    //  nueva propiedad

            
            // obtenemos la imagen del logo y la procesamos
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            
            if ($model->imageFile ) {
                // file is uploaded successfully
                $model->uploadFoto();  
            }
            // generamos el archivo de estilo
             $model->generateCss();
       

            if($model->save(false)){
                return $this->redirect(['index']);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            
        ]);
    }

    /**
     * Updates an existing Apps model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile ) {
                // file is uploaded successfully
                $model->uploadFoto();  
            }
            $model->generateCss();

            if($model->save(false)){
                return $this->redirect(['index']);
            }
          
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Apps model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

   //
    public function actionRunApp($id){

            $model=$this->findModel($id);
            
            if($model && $model->codigoApp===Apps::$APP_COMMERCE_GRAFICA){
                return $this->render('grafica/index', [
                    'model' => $model,
                ]);
            }
            return $this->redirect(['index']); 
    }
	
	
	// prueba-----------
	 public function actionReact($id){
		 $this->layout = 'layout_react';

            $model=$this->findModel($id);
            
          
           return $this->render('react', [
                    'model' => $model,
                ]);
           
    }

    public function actionUpload($idApp)
    {
        $modelf = new UploadForm();
         //Validación mediante ajax
            if ($modelf->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
            {
                //Yii::$app->response->format = Response::FORMAT_JSON;
                $modelf->imageFile = UploadedFile::getInstance($modelf, 'imageFile');
                if ($modelf->upload($idApp)) {
                    // file is uploaded successfully
                   // return ['urlFile'=>$model->urlFile];
                   return $this->render("_uploadFileForm",['model'=>$modelf]);
                }
               // return ActiveForm::validate($model);
            }

/*
        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload($idApp)) {
                // file is uploaded successfully
                return;
            }
        }

        return $this->render('_uploadFileForm', ['model' => $model]);*/
    }

    /**
     * Finds the Apps model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Apps the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apps::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
