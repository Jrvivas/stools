<?php

namespace app\models;

use \yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use app\models\Invitado;
use Yii;

/**
 * @property type $id Description
 * @property type $nombre Description
 * @property type $username Description
 * @property type $password Description
 * @property type $authKey Description
 * @property type $accessToken Description
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface {
    

    const ROLE_USER = 10;
    const ROLE_RESPONSABLE = 15;
    const ROLE_ADMIN = 20;
    const ROLE_SUPERUSER = 30;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;



     public static function tableName()
    {
        return 'users';
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
       return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
     return static::findOne(['access_token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->id;
    }


    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {

       // echo "passwin ". crypt($password, Yii::$app->params["salt"])." pass ".$this->password;
            $passwCal=crypt($password,Yii::$app->params["salt"]);
            return hash_equals($this->password,$passwCal);    
       // return $this->password ===  $encripPassw;
    }
    
     public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->authKey = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    /* Busca la identidad del usuario a través del username */
    public static function findByUsername($username)
    {
        $user = User::find()
                ->andWhere("username=:username", [":username" => $username])
                ->one();
        return $user;
    }



    public static function roleInArray($arr_role)
        {
        return in_array(Yii::$app->user->identity->role, $arr_role);
        }


    public static function isActive()
        {
        return Yii::$app->user->identity->status == self::STATUS_ACTIVE;
        }

   /**
    * Devuelve el rol del usario en la aplicación pasada su id
    */
   public static function getRole($idApp){
        $idUser=Yii::$app->user->identity->id;
        $invitado=Invitado::find()->where(['app_idApp'=>$idApp,'idInvitado'=>$idUser])->one();
        if($invitado){
            return $invitado->role;
        }else{
            $app=Apps::find()->where(['idApp'=>$idApp,'idUser'=>$idUser])->one();
            if($app){
                return Yii::$app->user->identity->role;
            }else{
                return 0;
            }
        }
    } 

 /**
  * 
  */
    public static function isInvitado($idApp){
        $idUser=Yii::$app->user->identity->id;
        $invitado=Invitado::find()->where(['app_idApp'=>$idApp,'idInvitado'=>$idUser])->one();
        if($invitado){
            return true;
        }else{
           return false;
        }

    }
    

    /**
     * Devuelve un array con todos los ides de los empleados a cargo y sus sub-empleados
     */
    public static function getEmployes($idApp,$idUser){
       
        $todos=[];
        $empleados=Invitado::find()->where(['app_idApp'=>$idApp,'idSuperior'=>$idUser])->all();
        $emps=[];
        
        foreach($empleados as $emp){
            $emps[]=$emp->idInvitado;
            $todos=array_merge($todos,User::getEmployes($idApp,$emp->idInvitado));
        }

        return array_merge($emps,$todos);

    }



}
