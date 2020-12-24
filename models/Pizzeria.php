<?php
namespace app\models;

use yii\base\Model;

class Pizzeria extends Model{
    public $id;
    public $IdUser;
    public $nombre;
    public $herramientas;

    public function getHerramientas(){
        return[];
    }
    
}