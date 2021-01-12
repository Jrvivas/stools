<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "archivo".
 *
 * @property string $id
 * @property string $idApp
 * @property string|null $nombre
 * @property string|null $url
 * @property string $tamanio NORMAL,MINI,MICRO     -,300x300,94x94 
 * @property string $tipo FOTO,FILE
 *
 * @property Productos[] $productos
 * @property Tipoproducto[] $tipoproductos
 */
class Archivo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'archivo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idApp'], 'required'],
            [['id', 'url'], 'string', 'max' => 255],
            [['idApp', 'nombre'], 'string', 'max' => 124],
            [['tamanio'], 'string', 'max' => 20],
            [['tipo'], 'string', 'max' => 45],
            [['id', 'idApp'], 'unique', 'targetAttribute' => ['id', 'idApp']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idApp' => 'Id App',
            'nombre' => 'Nombre',
            'url' => 'Url',
            'tamanio' => 'Tamanio',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['idFoto' => 'id', 'app_idApp' => 'idApp']);
    }

    /**
     * Gets query for [[Tipoproductos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoproductos()
    {
        return $this->hasMany(Tipoproducto::className(), ['idFoto' => 'id', 'idApp' => 'idApp']);
    }
}
