<?php
namespace app\models;
use Yii;
use yii\web\Controller;
use app\models\Apps;
use yii\filters\VerbFilter;

abstract class AppController extends Controller{
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



    //-----------------------------------------------------------------
    /**
     * Obtiena la aplicacion y le asigna un layout segun su tipo
     */


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
         if($app && $role!=0 && isset(Yii::$app->user->identity)){

 
             // Definimos el parametro global para una sesion de la Aplicacion
             Yii::$app->params['sesionApp']['idApp']=$idApp;
             Yii::$app->params['sesionApp']['nameApp']=$app->nombre;
             Yii::$app->params['sesionApp']['typeApp']=$app->codigoApp;
             Yii::$app->params['sesionApp']['userId']=Yii::$app->user->identity->id;
             Yii::$app->params['sesionApp']['userName']=isset(Yii::$app->user->identity->nombre)?Yii::$app->user->identity->nombre:Yii::$app->user->identity->username ;
             Yii::$app->params['sesionApp']['userRole']=$role;
             $this->layout = 'layout_app';


         }else{
    
            return $this->redirect(['/apps/index', 
                'error' => 'No hay una app seleccionada' ]);
        }  


    }
    protected function findApp($app_idApp){
        return Apps::findOne(['idApp'=>$app_idApp]);
    }



}