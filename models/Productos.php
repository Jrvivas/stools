<?php

namespace app\models;

use phpDocumentor\Reflection\Types\Null_;
use Yii;

/**
 * This is the model class for table "productos".
 *
 * @property int $id
 * @property string $app_idApp
 * @property string|null $codigo
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $urlFoto
 * @property string $estado
 * @property float $precio
 * @property float $costo
 * @property float $costoBase
 * @property int $idLista
 * @property string|null $opciones
 * @property string $unidad
 * @property float $unxCaja
 * @property float $cajaxPallet
 * @property string|null $categoriaCodigo
 * @property Detallepedido[] $detallepedidos
 * @property Apps $appIdApp
 */
class Productos extends \yii\db\ActiveRecord
{
   
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos';
    }

    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'app_idApp', 'nombre','precio', 'costo',], 'required'],
            [['id','idTipoProducto','idLista'], 'integer'],
            [['precio', 'costo', 'costoBase','costoInstalacion','unxCaja','cajaxPallet'], 'number'],
            [['app_idApp', 'codigo'], 'string', 'max' => 124],
            [['nombre', 'urlFoto','categoriaCodigo'], 'string', 'max' => 255],
            [['descripcion', 'opciones'], 'string', 'max' => 512],
            [['estado', 'unidad'], 'string', 'max' => 16],
            [['id', 'app_idApp'], 'unique', 'targetAttribute' => ['id', 'app_idApp']],
            [['app_idApp'], 'exist', 'skipOnError' => true, 'targetClass' => Apps::className(), 'targetAttribute' => ['app_idApp' => 'idApp']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_idApp' => 'App Id App',
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'urlFoto' => 'Foto',
            'estado' => 'Estado',
            'precio' => 'Precio',
            'costo' => 'Costo',
            'costoBase' => 'Costo base',
            'costoInstalacion'=>'Costo de Instalación',
            'idLista' => 'Lista de precio',
            'opciones' => 'Opciones',
            'unidad' => 'Unidad',
            'unxCaja'=>'Productos x Caja',
            'cajaxPallet'=>'Cajas por Pallet',
            'categoriaCodigo'=>'Categoria'
        ];
    }

    /**
     * Gets query for [[Detallepedidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetallepedidos()
    {
        return $this->hasMany(Detallepedido::className(), ['productos_id' => 'id', 'pedido_app_idApp' => 'app_idApp']);
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
     * Gets query for [[AppIdApp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['app_idApp' => 'app_idApp','codigo'=>'categoriaCodigo']);
    }

        /**
     * Gets query for [[AppIdApp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['app_idApp' => 'app_idApp','idProducto'=>'id']);
    }

    public function getPrecio($idCliente){
        $precio=Precio::findOne(['app_idApp' => $this->app_idApp, 'idProducto'=>$this->id,'idCliente'=>$idCliente]);
        if($precio){
            return ["nombre"=>$precio->nombre,"precio"=>$precio->precio,"fechaAct"=>$precio->fechaAct,"style"=>$precio->style,"formula"=>$precio->formula];
        }else{
            return NULL;
        }
    }


    public function maxId($id){
       return $this->find()->where(['app_idApp'=>$id])->max('id');
    }
}
