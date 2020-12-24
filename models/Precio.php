<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Precio".
 *
 * @property int $idProducto
 * @property string $app_idApp
 * @property int $idCliente
 * @property string $nombre
 * @property float $precio
 * @property string $fechaAct
 * @property string $style
 * @property string $formula

 * @property Apps $aplicacion
 * @property Producto $producto
 */
class Precio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'precio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idProducto', 'app_idApp', 'precio','idCliente'], 'required'],
            [['app_idApp'], 'string', 'max' => 124],
            [['nombre'], 'string', 'max' => 80],
            [['formula','style'], 'string', 'max' => 255],
            [['fechaAct'], 'safe'],
            [['idProducto','idCliente' ,'app_idApp'], 'unique', 'targetAttribute' => ['idProducto', 'idCliente' ,'app_idApp']],
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
            'nombre' => 'Nombre',
            'formula' => 'Formula',
            'fechaAct'=> 'Fecha Actualizacion',
            'precio'=>'Precio',
            'style'=>'Estilos'
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


}
