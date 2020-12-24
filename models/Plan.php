<?php
namespace app\models;

class Plan{
    public static function list(){
        return [['codigo'=>'PLAN_GRATIS','nombre'=>'Gratis por un mes','tarifa'=>0,'periodo'=>'1M','limites'=>['contactos'=>100,'pedidos'=>3100,'productos'=>50,'invitados'=>5]],
        ['codigo'=>'PLAN_EMPRENDEDOR','nombre'=>'Plan para emprendedores','tarifa'=>1000,'periodo'=>'1M','limites'=>['contactos'=>100,'pedidos'=>3100,'productos'=>50,'invitados'=>5]],
        ['codigo'=>'PLAN_COMERCIANTE','nombre'=>'Plan para comerciantes','tarifa'=>2000,'periodo'=>'1M','limites'=>['contactos'=>1000,'pedidos'=>31000,'productos'=>200,'invitados'=>20]],
        ['codigo'=>'PLAN_EMPRESARIO','nombre'=>'Plan para empresarios','tarifa'=>4000,'periodo'=>'1M','limites'=>['contactos'=>5000,'pedidos'=>310000,'productos'=>1000,'invitados'=>100]],];
    }

}