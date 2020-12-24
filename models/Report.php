<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\Pedido;

class Report extends Model{
    public static $_TIPO_ESTADISTICA=0;
    public static $_TIPO_REPORTES=10;
    public static $_TIPO_REPORTES_VENTA_CLIENTE=11;
    public static $_TIPO_REPORTES_VENTA_USUARIO=12;

    public $idApp='';           //id de la Aplicacion
    public $tipo=0;             //Es un codigo que indica el tipo de operacion se realiazará
    public $idResponsable=0;
    public $fechaIni=null;
    public $fechaFin=null;
    public $porcentage=0;

     /**
     * {@inheritdoc}
     */
    public function rules(){
        return [[['idApp','idResponsable',"fechaIni","fechaFin"],'required'],
                [['idResponsable','tipo'], 'integer'],
                [['idApp'],'string'],
                [['tipo'], 'safe'],
                [['fechaIni','fechaFin'],'date','format' =>'yyyy-MM-dd'],
                [['porcentage'],'double'],

        ];
    }


      /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idResponsable'=>'Cliente',
            'fechaIni'=>'Fecha de inicio',
            'fechaFin'=>'Fecha fin',
            'porcentage'=>'Porcentage'

        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return Contacto::find()->where(['id'=>$this->idResponsable,'app_idApp'=>$this->idApp])->one();
    }
    public function getUser()
    {
        return User::findOne($this->idResponsable);
    }


    /**
     * @param string $idApp 
     * Metodo que devuelve un DataProvider con la lista resultado
     * según la información del modelo, ademas un resumen del monto saldo y promedio
     * @return yii\data\ActiveDataProvider
     */
    public function getResumen(){

        //Valida si los datos son correctos
        if($this->validate()){
           
                $query=null;
            // echo "entramos".$this->tipo;exit;
                switch($this->tipo){
            
                    case Report::$_TIPO_REPORTES_VENTA_CLIENTE:
                        
                        $query=Pedido::find();
                        /*
                        SELECT * FROM `pedido` WHERE (app_idApp='216b68d3638b76c2-20200527081443' AND contacto_id=244 AND estado='ENTREGADO' ) AND (`fechaIni` BETWEEN '2020-07-17' AND '2020-11-30')
                        */

                        //Hacer el filtro para todos los cliente
                  
                    
                        $query->where("app_idApp='$this->idApp' AND contacto_id={$this->idResponsable} AND estado='ENTREGADO' ");
                        $query->andWhere(['between', 'fechaIni', $this->fechaIni, $this->fechaFin]);

                        //TODO -- Obtener el resumen --

                        return  new ActiveDataProvider([ 'query' => $query, 'pagination'=>false]);

                    break;
                    case Report::$_TIPO_REPORTES_VENTA_USUARIO:
                        
                        $query=Pedido::find();
                        /*
                        SELECT * FROM `pedido` WHERE (app_idApp='216b68d3638b76c2-20200527081443' AND contacto_id=244 AND estado='ENTREGADO' ) AND (`fechaIni` BETWEEN '2020-07-17' AND '2020-11-30')
                        */

                        //Hacer el filtro para todos los cliente
                        $ids=array_merge([$this->idResponsable],User::getEmployes($this->idApp,$this->idResponsable));
                        $idsResp=implode(',',$ids);

                        $query->where("app_idApp='$this->idApp' AND idResponsable IN ($idsResp) AND estado='ENTREGADO' ");
                        $query->andWhere(['between', 'fechaIni', $this->fechaIni, $this->fechaFin]);

                        //TODO -- Obtener el resumen --

                        return  new ActiveDataProvider([ 'query' => $query,  'pagination'=>false ]);

                    break;
                }
        }else{

        }
    }

    /**
     * Metodo que devuenve una lista de responsable  (key=>valor) sengun el tipo de reporte
     * @return array
     */
    public function listResp(){
        switch($this->tipo){

            case Report::$_TIPO_REPORTES_VENTA_CLIENTE:
                $clientes=Contacto::find()->where(["app_idApp"=>$this->idApp,"cliente"=>'SI'])->orderBy('nombre ASC')->all();
                return ArrayHelper::map($clientes,'id','nombre');

            case Report::$_TIPO_REPORTES_VENTA_USUARIO:   
                $idsUsers=User::getEmployes($this->idApp,Yii::$app->params['sesionApp']['userId']);

                $where=count($idsUsers)>1?' id IN ('.implode(',',$idsUsers).')':'id='.$idsUsers[0];

                $users=User::find()->where("status=10 AND ".$where)->all();
                return ArrayHelper::map($users,'id','nombre');
        }
        return [];

    }


}