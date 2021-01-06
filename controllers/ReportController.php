<?php
namespace app\controllers;
use yii\web\Controller;//======================SACAR
use app\models\AppController;
use app\models\Apps;
use app\models\Report;
use app\models\User;//======================SACAR

use yii\filters\VerbFilter; //======================SACAR
use Yii;

class ReportController extends Controller{//======================cambiar
       
    //=========================================== SACAR
            /**
         * {@inheritdoc}
         */
        public function behaviors()
        {
        //--------Verifica la Aplicacion----
         $this->verifApp();
       
         //-------------------------
            return [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }
        //===========================================




    /**
     * En el inicio mostraremos los datos predeterminados
     * @inheritdoc
     */
    public function actionIndex($idApp,$tipo){
         
        //Obtener el modelo de preporte
        $model=new Report();    //Referenciamos el objeto Reporte
        $model->idApp=$idApp;   //Le damos la identidad de la aplicacion
        $model->tipo=$tipo;
        $dataProvider=null;     //Iniciamos el dataProvider
      

        //Obtenemos los datos del formulario
        $model->attributes=Yii::$app->request->post('Report');

        // --------debug para  visualizar datos
        // var_dump(Yii::$app->request->post('Report',[]));
       // echo "tipo ".$model->tipo;
       // echo "Ids Eployes".var_dump($model->listResp());
        //------------------------
        
        if($model->validate()){
            // Si se validó el formulario carga el dataProvide
            // el valor 900 indica edicion 
             if($model->tipo<900){
                 $dataProvider=$model->getResumen($idApp);
             }  
        }

        //Renderisa la vista
        return $this->render('index',['model'=>$model,
                                    'dataProvider'=>$dataProvider]);

    }



    ///----------------------------------SOLO PARA HACER FUNCIONAR DISTRIBUIDORA------------------
    //================================================================================================
    protected function verifApp(){

        /**Verificar si se ha pasado el Id de la Aplicacion saber como comportarse */
        $idApp='';
        // en la consultas Get
        if(isset($_GET['idApp'])) $idApp=$_GET['idApp'];
        if(isset($_GET['app_idApp'])) $idApp=$_GET['app_idApp'];

        // en las consultas post ??

        //Identificar la aplicación
         //Identificar el tipo de app
         $app=$this->findApp($idApp);
         $role=User::getRole($idApp);
         Yii::$app->variables=['idApp'=>$idApp];
        
         
         if($app && $role!=0 && isset(Yii::$app->user->identity)){

 
             // Definimos el parametro global para una sesion de la Aplicacion
             Yii::$app->params['sesionApp']['idApp']=$idApp;
             Yii::$app->params['sesionApp']['nameApp']=$app->nombre;
             Yii::$app->params['sesionApp']['typeApp']=$app->codigoApp;
             Yii::$app->params['sesionApp']['userId']=Yii::$app->user->identity->id;
             Yii::$app->params['sesionApp']['userName']=isset(Yii::$app->user->identity->nombre)?Yii::$app->user->identity->nombre:Yii::$app->user->identity->username ;
             Yii::$app->params['sesionApp']['userRole']=$role;
            // Yii::$app->variables['idApp']=$idApp;
             $this->layout = 'layout_distribuidora';


         }else{
    
            return $this->redirect(['/apps/index', 
                'error' => 'No hay una app seleccionada' ]);
        }
    }

    protected function findApp($app_idApp){
        return Apps::findOne(['idApp'=>$app_idApp]);
    }
    //========================================================================================

}