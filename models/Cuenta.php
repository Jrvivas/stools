<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cuenta".
 *
 * @property string $app_idApp
 * @property int $contacto_id
 * @property string|null $nombre
 * @property float $saldo
 * @property string $fecha
 * @property int $estado
 */
class Cuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_idApp', 'contacto_id','nombre' ,'saldo'], 'required'],
            [['contacto_id', 'estado'], 'integer'],
            [['saldo'], 'number'],
            [['fecha'], 'safe'],
            [['app_idApp', 'nombre'], 'string', 'max' => 124],
            [['app_idApp', 'contacto_id'], 'unique', 'targetAttribute' => ['app_idApp', 'contacto_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'app_idApp' => 'App Id App',
            'contacto_id' => 'Contacto',
            'nombre' => 'Nombre',
            'saldo' => 'Saldo',
            'fecha' => 'Fecha',
            'estado' => 'Estado',
        ];
    }

   

}
