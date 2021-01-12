<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "movimiento".
 *
 * @property int $id
 * @property string $app_idApp
 * @property int $contacto_id
 * @property string $fecha
 * @property float|null $entrada
 * @property float|null $salida
 * @property int $tipo
 * @property string|null $comentario
 * @property string|null $fecha_tipo
 * @property string|null $opciones
 */
class Movimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'app_idApp', 'contacto_id'], 'required'],
            [['id', 'contacto_id', 'tipo'], 'integer'],
            [['fecha', 'fecha_tipo'], 'safe'],
            [['entrada', 'salida'], 'number'],
            [['app_idApp'], 'string', 'max' => 124],
            [['comentario', 'opciones'], 'string', 'max' => 512],
            [['id', 'app_idApp', 'contacto_id'], 'unique', 'targetAttribute' => ['id', 'app_idApp', 'contacto_id']],
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
            'contacto_id' => 'Contacto ID',
            'fecha' => 'Fecha',
            'entrada' => 'Entrada',
            'salida' => 'Salida',
            'tipo' => 'Tipo',
            'comentario' => 'Comentario',
            'fecha_tipo' => 'Fecha Tipo',
            'opciones' => 'Opciones',
        ];
    }
}
