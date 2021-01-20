<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property int $id
 * @property string $app_idApp
 * @property int $contacto_id
 * @property int $idResponsable
 * @property int $idModifico
 * @property string $nombre
 * @property string $fechaIni
 * @property string|null $fechaFin
 * @property string|null $fechaEntrega
 * @property int $delivery
 * @property string|null $comentarios
 * @property float|null $monto
 * @property float|null $pago
 * @property float|null $saldo
 * @property float $descuento
 * @property float|null $impuesto
 * @property string|null $estado
 * @property int $prioridad
 * @property Detallepedido[] $detallepedidos
 * @property Apps $appIdApp
 */
class Pedido extends \yii\db\ActiveRecord
{
    public static $_ESTADO_NULO="NULL";
    public static $_ESTADO_PRESUPUESTO="PRESUPUESTO";
    public static $_ESTADO_ESPERA="ESPERA";
    public static $_ESTADO_APROBADO="APROBADO";
    public static $_ESTADO_DISENIO="DISENIO";
    public static $_ESTADO_PRODUCCION="PRODUCCION"; //ELABORACION
    public static $_ESTADO_RETRASADO="RETRASADO";
    public static $_ESTADO_TERMINADO="TERMINADO";
    public static $_ESTADO_ENTREGADO="ENTREGADO";
    public static $_ESTADO_RECHAZADO="RECHAZADO";

    public static $_FECHA_NO_NECESARIA=-999;

    public $accion="";


    /**
     * Lista de estado con un label
     */
    public static function listEstados(){
        return[Pedido::$_ESTADO_PRESUPUESTO=>'Presupuesto',
               Pedido::$_ESTADO_ESPERA =>'Espera',
               Pedido::$_ESTADO_APROBADO =>'Aprobado',
               Pedido::$_ESTADO_DISENIO =>'Diseño',
               Pedido::$_ESTADO_PRODUCCION=>'Producción',
               Pedido::$_ESTADO_RETRASADO=>'Retrasado',
               Pedido::$_ESTADO_TERMINADO=>'Terminado',
               Pedido::$_ESTADO_ENTREGADO=>'Entregado',
               Pedido::$_ESTADO_RECHAZADO=>'Rechazado'
               ];
    }

    /**
     * Lista de Prioridades
     */
    public static function listaPrioridades(){
        return [0 => 'Normal', 2 => 'Media', 4 => 'Alta', 8 => 'Urgente', 10 => 'Hoy'];
    }
       
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'app_idApp', 'contacto_id', 'nombre', 'fechaIni'], 'required'],
            [['id', 'contacto_id', 'idResponsable','delivery','prioridad','idModifico'], 'integer'],
            ['idModifico','default','value'=>null],
            [['fechaIni', 'fechaFin', 'fechaEntrega','accion'], 'safe'],
            [['monto','pago','saldo','costo'], 'number'],
            [['app_idApp','nombre'], 'string', 'max' => 124],
            [['descuento', 'impuesto'], 'string', 'max' => 45],
            [['comentarios'], 'string', 'max' => 512],
            [['estado','accion'], 'string', 'max' => 20],
            [['id', 'app_idApp'], 'unique', 'targetAttribute' => ['id', 'app_idApp']],
            [['app_idApp'], 'exist', 'skipOnError' => true, 'targetClass' => Apps::className(), 'targetAttribute' => ['app_idApp' => 'idApp']],
        ];
    }

    public function __construct()
    {
            parent::__construct();
            $this->contacto_id=null;   //Cliente eventual
            $this->descuento = 0;
            $this->impuesto = 0;
            $this->pago = 0;
            $this->saldo = 0;
            $this->monto = 0;
            $this->costo=0;
            $this->estado =Pedido::$_ESTADO_NULO;
            $this->prioridad = 0; //Normal

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_idApp' => 'App Id App',
            'contacto_id' => 'Contacto ID',
            'idResponsable'=>'Id Responsable',
            'idModifico'=>'Id que Modifico',
            'nombre' => 'Nombre',
            'fechaIni' => 'Fecha del pedido',
            'fechaFin' => 'Fecha Fin',
            'fechaEntrega' => 'Fecha Entrega',
            'delivery' => 'Delivery',
            'comentarios' => 'Comentarios',
            'monto' => 'Monto',
            'costo'=>'Costo',
            'pago' => 'Pagado',
            'Saldo' => 'Saldo',
            'descuento' => 'Descuento',
            'impuesto' => 'Impuesto',
            'estado' => 'Estado',
            'prioridad'=>'Prioridad'
        ];
    }


   
    /**
     * Gets query for [[Detallepedidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetallepedidos() //----------------------------??????????????????????? CUAL SE USA!!!
    {
        return $this->hasMany(Detallepedido::className(), ['pedido_id' => 'id', 'pedido_app_idApp' => 'app_idApp']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallesPedido()      //----------------------------???????????????????????CUAL SE USA!!!
    {
        return $this->hasMany(DetallePedido::className(), ['app_idApp'=>'app_idApp', 'pedido_id'=>'id']);
    }




    /**
     * Gets query for [[AppIdApp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppIdApp()
    {
        return $this->hasOne(Apps::className(), ['idApp' => 'app_idApp']);
    }

           /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Contacto::className(), ['app_idApp' => 'app_idApp','id' => 'contacto_id']);
    }
   /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsable()
    {
        return $this->hasOne(User::className(), ['id' => 'idResponsable']);
    }

       /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifico()
    {
        return $this->hasOne(User::className(), ['id' => 'idModifico']);
    }



    /**
     * Busca el maximo id  de los pedido 
     */
    public function maxId($id){
        return $this->find()->where(['app_idApp'=>$id])->max('id');
     }


     public function calcular(){
         $this->monto=0;
         $this->costo=0;
         $descuento=$this->descuento;
         $recargo=$this->impuesto;

         foreach($this->detallesPedido as $d){
                $this->monto+=$d->monto;
                $this->costo+=$d->costo;
         }
         $this->save();
        

     }

    /**
     * Metodo que indica si el el Pedido es editable o no
     * @return boolean
     */
    public function isEditable(){
           if ($this->estado == Pedido::$_ESTADO_ENTREGADO) {
                return false;
            } else {
                return true;
            }
    }
  


     //-------------------------------------------
     function dateDiff($date1, $date2)  //days find function
    { 
        $diff = strtotime($date2) - strtotime($date1); 
        if($diff>0){
            return abs(round($diff / 86400)); 
        }else{
            return abs(round($diff / 86400))*-1; 
        }
        
    } 

    public function diasInicio(){
        return $this->dateDiff($this->fechaIni,date("Y-m-d"));
    }

    /**
     * Devuelve los días que faltan para la entrega acordada del producto o servicio
     * @return int un número positivo o negativo o la constante de fecha entrega no requerida
     */
    public function diasEntrega(){
        if(!in_array($this->estado,[Pedido::$_ESTADO_ESPERA,Pedido::$_ESTADO_ENTREGADO] )){
            return $this->dateDiff(date("Y-m-d"),$this->fechaEntrega);
        }else{
            return Pedido::$_FECHA_NO_NECESARIA;
        }
        
    }


    /**
      * Devuelve el objeto en un json cargado
      */
      public function toJson(){
        return  json_encode($this->find()->where(['id'=>$this->id,'app_idApp'=>$this->app_idApp])->asArray()->one());
    }
    //------------------------------------------------





      
      
}
