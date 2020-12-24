<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "familia".
 *
 * @property int $id
 * @property string $app_idApp
 * @property string $nombre
 * @property string $prefijo
 * @property int $idPadre
 * @property int $esProducto
 */
class Familia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'familia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'app_idApp', 'nombre', 'prefijo', 'idPadre'], 'required'],
            [['id', 'idPadre', 'esProducto'], 'integer'],
            [['app_idApp'], 'string', 'max' => 124],
            [['nombre'], 'string', 'max' => 80],
            [['prefijo'], 'string', 'max' => 20],
            [['id', 'app_idApp'], 'unique', 'targetAttribute' => ['id', 'app_idApp']],
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
            'prefijo' => 'Prefijo',
            'idPadre' => 'Id Padre',
            'esProducto' => 'Es Producto',
        ];
    }
}
