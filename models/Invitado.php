<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invitado".
 *
 * @property string $app_idApp
 * @property int $idInvitado
 * @property int $idPropietario
 * @property int $idSuperior
 * @property int $role

 * @property Apps $appIdApp
 */
class Invitado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invitado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPropietario', 'app_idApp', 'idInvitado'], 'required'],
            [['app_idApp'], 'string', 'max' => 124],
            [['idPropietario','idInvitado'], 'number'],
            [['idPropietario', 'app_idApp', 'idInvitado'], 'unique', 'targetAttribute' => ['idPropietario', 'app_idApp', 'idInvitado']],
            [['app_idApp'], 'exist', 'skipOnError' => true, 'targetClass' => Apps::className(), 'targetAttribute' => ['app_idApp' => 'idApp']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'app_idApp' => 'Id de Aplicacion',
            'idPropietario' => 'id Propietario',
            'idInvitado' => 'id Invitado',
            'role'=>'Rol'
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
     * Gets query for [[Propietario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropietario()
    {
        return $this->hasOne(User::className(), ['id' => 'idPropietario']);
    }
    
    /**
     * Gets query for [[invitado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvitado()
    {
        return $this->hasOne(User::className(), ['id' => 'idInvitado']);
    }


}
