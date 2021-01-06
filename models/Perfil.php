<?php
namespace app\models;

class Perfil{
   
   /**
    * Devuelve un array con los link que el usuario puede usar en la aplicación segun su perfil
    * @param  string $codigoPederfil Código del perfil ej:"ADM", "EJE", "RES", "OPE"
    * @param  string $idApp Código de la aplicación
    * @return array  ej [['urlIcon'=>'','label'=>'Reporte', 'url'='...','help'=>'descripcion breve de la función',menu'=>[]],...]
    */
   public static function getConfigMenu($codigoPederfil,$idApp){
       $iconReport='assets/icons/card-checklist.svg';
       $iconPedido='assets/icons/clipboard.svg';
       $iconProducto='assets/icons/box-seam.svg';
       $iconContacto='assets/icons/people-fill.svg';
       $iconConfiguracion='assets/icons/gear.svg';
       
       /*TODO
        Iconos de presentación para ayudas y fijas de presentación
       */
       $iconReportPress='assets/imgs/img_present_reporte.svg';
       $iconPedidoPress='assets/imgs/img_present_pedido.svg';
       $iconProductoPress='assets/imgs/img_present_producto.svg';
       $iconContactoPress='assets/imgs/img_present_contacto.svg';
       $iconConfiguracionPress='assets/imgs/img_present_config.svg';
       

       $helpReporte='Para ver  estadisticas y reportes';
       $helpPedido='Para el manejo de pedidos, presupuestos, tareas..';
       $helpContacto='Aquí  puede manejar sus clientes, proveedores';
       $helpProducto='Aquí   podrá manejar los productos, categorias, marcas';
       $helpConfiguracion='Configurar el sistema (Ususrios, estetica, etc.)';

        switch($codigoPederfil){

            case "ADM":
                return [
                ['nombre'=>'pedido','urlIcon'=>$iconPedido,'label'=>'Pedidos','url'=>\Yii::$app->urlManager->createUrl(['/pedido/index','idApp'=>$idApp]),'help'=>$helpPedido,'menu'=>[]],
                ['nombre'=>'producto','urlIcon'=>$iconProducto,'label'=>'Productos','url'=>\Yii::$app->urlManager->createUrl(['/producto/index','idApp'=>$idApp]),'help'=>$helpProducto,'menu'=>[]],
                ['nombre'=>'contacto','urlIcon'=>$iconContacto,'label'=>'Contactos','url'=>\Yii::$app->urlManager->createUrl(['/contacto/index','idApp'=>$idApp]),'help'=>$helpContacto,'menu'=>[]],
                ['nombre'=>'reporte','urlIcon'=>$iconReport,'label'=>'Reporte', 'url'=>\Yii::$app->urlManager->createUrl(['/report/index','idApp'=>$idApp,'tipo'=>Report::$_TIPO_ESTADISTICA]),'help'=>$helpReporte,'menu'=>[]],
                ['nombre'=>'configuracion','urlIcon'=>$iconConfiguracion,'label'=>'Configuración','url'=>\Yii::$app->urlManager->createUrl(['/config/index','idApp'=>$idApp]),'help'=>$helpConfiguracion,'menu'=>[]]];

            case "EJE":
                return [
                ['nombre'=>'pedido','urlIcon'=>$iconPedido,'label'=>'Pedidos','url'=>\Yii::$app->urlManager->createUrl(['/pedido/index','idApp'=>$idApp]),'help'=>$helpPedido,'menu'=>[]],
                ['nombre'=>'producto','urlIcon'=>$iconProducto,'label'=>'Productos','url'=>\Yii::$app->urlManager->createUrl(['/productos/index','idApp'=>$idApp]),'help'=>$helpProducto,'menu'=>[]],
                ['nombre'=>'contacto','urlIcon'=>$iconContacto,'label'=>'Contactos','url'=>\Yii::$app->urlManager->createUrl(['/contacto/index','idApp'=>$idApp]),'help'=>$helpContacto,'menu'=>[]],
                ['nombre'=>'reporte','urlIcon'=>$iconReport,'label'=>'Reporte', 'url'=>\Yii::$app->urlManager->createUrl(['/report/index','idApp'=>$idApp,'tipo'=>Report::$_TIPO_ESTADISTICA]),'help'=>$helpReporte,'menu'=>[]],
                ['nombre'=>'configuracion','urlIcon'=>$iconConfiguracion,'label'=>'Configuración','url'=>\Yii::$app->urlManager->createUrl(['/config/index','idApp'=>$idApp]),'help'=>$helpConfiguracion,'menu'=>[]]];
                
            case "RES":
                return [['nombre'=>'reporte','urlIcon'=>$iconReport,'label'=>'Reporte', 'url'=>\Yii::$app->urlManager->createUrl(['/report/index','idApp'=>$idApp,'tipo'=>Report::$_TIPO_ESTADISTICA]),'help'=>$helpReporte,'menu'=>[]],
                ['nombre'=>'pedido','urlIcon'=>$iconPedido,'label'=>'Pedidos','url'=>\Yii::$app->urlManager->createUrl(['/pedido/index','idApp'=>$idApp]),'help'=>$helpPedido,'menu'=>[]],
                ['nombre'=>'producto','urlIcon'=>$iconProducto,'label'=>'Productos','url'=>\Yii::$app->urlManager->createUrl(['/producto/index','idApp'=>$idApp]),'help'=>$helpProducto,'menu'=>[]],
                ['nombre'=>'contacto','urlIcon'=>$iconContacto,'label'=>'Contactos','url'=>\Yii::$app->urlManager->createUrl(['/contacto/index','idApp'=>$idApp]),'help'=>$helpContacto,'menu'=>[]],
               ];

            case "OPE":
                return [['nombre'=>'pedido','urlIcon'=>$iconPedido,'label'=>'Pedidos','url'=>\Yii::$app->urlManager->createUrl(['/pedido/index','idApp'=>$idApp]),'help'=>$helpPedido,'menu'=>[]],
                        ['nombre'=>'contacto','urlIcon'=>$iconContacto,'label'=>'Contactos','url'=>\Yii::$app->urlManager->createUrl(['/contacto/index','idApp'=>$idApp]),'help'=>$helpContacto,'menu'=>[]],
                       ];   
            
            default:
                return [['nombre'=>'pedido','urlIcon'=>$iconPedido,'label'=>'Pedidos','url'=>\Yii::$app->urlManager->createUrl(['/pedido/index','idApp'=>$idApp]),'help'=>$helpPedido,'menu'=>[]],
                        ['nombre'=>'contacto','urlIcon'=>$iconContacto,'label'=>'Contactos','url'=>\Yii::$app->urlManager->createUrl(['/contacto/index','idApp'=>$idApp]),'help'=>$helpContacto,'menu'=>[]]
                       ]; 


        }
   } 

   /**
    * Método estatico que genera los items del menú
    */
    public static function getItemsMenu($codigoPederfil,$idApp){

        $items=[];
        //  ['label' => 'Pedidos beta',  'options'=>['style'=>['background'=>'#fff70047'],'onclick' => 'mostrarPedidosB();']],
        foreach(Perfil::getConfigMenu($codigoPederfil,$idApp) as $item){
            $items[]=['label' => $item['label'],  'options'=>['onclick' => 'window.location.href = \''.$item['url'].'\';','title'=>$item['help']]];
        }

        return $items;

   }  
   
   
   /**
    * 
    */
    public static function roleToCodePerfil($roleId){
        switch($roleId){
            case 10:
                return 'OPE';
            case 15:
                return 'RES';
            case 20:
                return 'EJE';
            case 30:
                return 'ADM';
            default:
                return 'OPE';                
        }
    }




}


?>