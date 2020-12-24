<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacto".
 *
 * @property int $id
 * @property string $app_idApp
 * @property string $nombre
 * @property string $direccion
 * @property string $localidad
 * @property string $cel
 * @property string|null $tel
 * @property string|null $email
 * @property string|null $urlFoto
 * @property string $empresa
 * @property string|null $cuit
 * @property string $tipo
 * @property string $cliente
 * @property string $proveedor
 * @property string $operador
 * @property string $carpera
 * @property Apps $appIdApp
 * @property Pedido[] $pedidos
 */
class Contacto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'app_idApp', 'nombre', 'direccion', 'localidad', 'cel'], 'required'],
            [['id'], 'integer'],
            [['app_idApp', 'empresa'], 'string', 'max' => 124],
            [['nombre', 'localidad'], 'string', 'max' => 80],
            [['direccion', 'email', 'urlFoto','carpeta'], 'string', 'max' => 255],
            [['cel', 'tel'], 'string', 'max' => 20],
            [['cliente', 'proveedor','operador'], 'string', 'max' => 16],
            [['cuit', 'tipo'], 'string', 'max' => 16],
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
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
            'localidad' => 'Localidad',
            'cel' => 'Cel',
            'tel' => 'Tel',
            'email' => 'Email',
            'urlFoto' => 'Url Foto',
            'empresa' => 'Empresa',
            'cuit' => 'Cuit',
            'tipo' => 'Tipo',
            'carpeta'=>'Dirección en disco'
        ];
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
     * Gets query for [[Pedidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['contacto_id' => 'id', 'app_idApp' => 'app_idApp']);
    }

    public function maxId($id){
        return $this->find()->where(['app_idApp'=>$id])->max('id');
     }
}
