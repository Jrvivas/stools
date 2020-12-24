<?php

namespace app\models;

use Yii;
use app\models\User;

class Responsable extends User{
   
    public function fields()

    {
        $fields=parent::fields();
        unset($fields['username'],$fields['password'],$fields['accessToken'],$fields['authKey']);
        
        return $fields;
    }


}

