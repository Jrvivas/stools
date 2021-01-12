<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Precio".
 *
 * @property int $idProducto
 * @property string $app_idApp
 * @property string $fechaAct
 * @property float $cantidad
 * @property float $cantidadMin

 * @property Apps $aplicacion
 * @property Producto $producto
 */
class Stock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idProducto', 'app_idApp', 'cantidad','cantidadMin'], 'required'],
            [['app_idApp'], 'string', 'max' => 124],
            [['cantidad','cantidadMin'],'number'],
            [['fechaAct'], 'safe'],
            [['idProducto' ,'app_idApp'], 'unique', 'targetAttribute' => ['idProducto' ,'app_idApp']],
            [['app_idApp'], 'exist', 'skipOnError' => true, 'targetClass' => Apps::className(), 'targetAttribute' => ['app_idApp' => 'idApp']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idProducto' => 'id Producto',
            'app_idApp' => 'Id de Aplicacion',
            'fechaAct'=> 'Fecha Actualizacion',
            'cantidad'=>'Cantidad',
            'cantidadMin'=>'Cantidad Mínima'
        ];
    }

    /**
     * Gets query for [[AppIdApp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApp()
    {
        return $this->hasOne(Apps::className(), ['idApp' => 'app_idApp']);
    }
        /**
     * Gets query for [[AppIdApp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id'=>'idProducto','idApp' => 'app_idApp']);
    }

    public function addStock($cantidad){
        if($cantidad && is_numeric($cantidad)){
            $this->cantidad+=$cantidad;
            return $this->save();
        }
        return false;
        
    }
    
    public function remStock($cantidad){
        if($cantidad && is_numeric($cantidad)){
            $this->cantidad-=$cantidad;
            return $this->save();
        }
        return false;
        
    }



}
