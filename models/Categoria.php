<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property string $codigo
 * @property string $app_idApp
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $urlIcono
 * @property string|null $style
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'app_idApp', 'nombre'], 'required'],
            [['codigo', 'descripcion'], 'string', 'max' => 255],
            [['app_idApp'], 'string', 'max' => 124],
            [['nombre'], 'string', 'max' => 80],
            [['urlIcono', 'style'], 'string', 'max' => 252],
            [['codigo', 'app_idApp'], 'unique', 'targetAttribute' => ['codigo', 'app_idApp']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'app_idApp' => 'App Id App',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'urlIcono' => 'Url Icono',
            'style' => 'Style',
        ];
    }
}
