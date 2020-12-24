<?php

namespace app\models;

use Yii;
use \yii\data\ActiveDataProvider;

/**
 * This is the model class for table "apps".
 *
 * @property string $idApp
 * @property int $idUser
 * @property string $nombre
 * @property string $codigoApp Codigo de la aplicacion que hace referencia
 * @property string $codigoPlan código del plan de sevicio adquirido
 * @property string $codigoRubro  Código del rubro ala que pertenece la aplicación
 * @property string|null $urlLogo deprecated
 * @property string|null $color1 deprecated
 * @property string|null $color2  deprecated
 * @property string|null $color3  deprecated
 * @property string|null $color4  deprecated
 * @property string|null $style estilo de la aplicasion en base64
 *
 * @property Pedido[] $pedidos
 * @property Productos[] $productos
 */
class Apps extends \yii\db\ActiveRecord
{
    public static $APP_COMMERCE_GRAFICA='GRAFICA';
    public static $APP_COMMERCE_DITRIBUIDORA='DISTRIBUIDORA';
    public static $APP_COMMERCE_FAST_FOOD='FAST_FOOD';
    public static $APP_COMMERCE_PIZZERIA='PIZZERIA';


   /**
     * @var UploadedFile
     */
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apps';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idApp', 'idUser', 'nombre', 'codigoApp','codigoPlan'], 'required'],
            [['idUser'], 'integer'],
            [['fechaIni'],'date'],
            [['fechaIni'],'safe'],
            [['idApp'], 'string', 'max' => 124],
            [['codigoPlan','codigoApp'],'string','max'=>30],
            [['nombre'], 'string', 'max' => 100],
            [['color1', 'color2', 'color3','color4'], 'string', 'max' => 16],
            [['urlLogo'], 'string', 'max' => 255],
            [['idApp'], 'unique'],
            //[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idApp' => 'Id App',
            'idUser' => 'Id User',
            'nombre' => 'Nombre',
            'codigoApp' => 'Codigo App',
            'codigoPlan'=>'Plan de servicio',
            'urlLogo' => 'Url Logo',                    //Deprecated
            'color1' => 'Color de controles',           //Deprecated
            'color2' => 'Color de texto de controles',  //Deprecated
            'color3' => 'color de fondo',               //Deprecated
            'color4' => 'color de texto items',         //Deprecated
        ];
    }

    /**
     * Gets query for [[Pedidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    
    {
        return $this->hasMany(Pedido::className(), ['app_idApp' => 'idApp']);
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['app_idApp' => 'idApp']);
    }

    //------------------------------------------------------------------------


    /**
     * Este metodo devuelve los datos de los usuarios de la aplicación en forma 
     * jerarquica
     * Ej:
     * [{'nombre':'Monica Villanueva', 'idUser':2,'role':'ADMIN','superior':null},
     * {'nombre':'Javier Vivas', 'idUser':23,'role':'ADMIN','superior':2},
     * {'nombre':'Paulina', 'idUser':28,'role':'OPERADOR','superior':2}]
     */
    public function getUsers(){
        return[];

    }


  /**
   * método que genera y actualiza la estética de la aplicación
   */
    public function generateTheme(){
        
        $theme=new ThemeApp($this->idapp);

        /*TODO
        // analizar 
        $theme->setStyle($this->style);
        $theme->generateCss();
        $theme->generateIcons();
        $theme->generateImgsDocs();*/

     
    }
    /**
     * Método que genera los archivos css
     * @deprecated
     */
    public function generateCss(){
        $deletedFormat=':root {';
        $deletedFormat.='    --app-ctr-bg-color: '.$this->color1.';';
        $deletedFormat.='    --app-ctr-text-color: '.$this->color2.';/*nuevo*/';
        $deletedFormat.='    --app-bg-color: '.$this->color3.';';
        $deletedFormat.='    --app-text-color:rgb(19, 18, 18);/*rgb(117, 117, 117);*/';
        $deletedFormat.='    --app-text-Items: '.$this->color4.';';
        $deletedFormat.=' }';


          $nuevo_fichero='assets/apps/'.$this->idApp.'/css/site.css';
          
          $oldMessage="/*ROOT_VAR*/";
       
          if(!file_exists(dirname($nuevo_fichero))){
              mkdir(dirname($nuevo_fichero), 0777, true);
          }
          

          if (copy('css/tmp_site.css', $nuevo_fichero)) {

                    Util::replace_string_in_file($nuevo_fichero,$oldMessage,$deletedFormat);
          }else{
              echo 'ERROR';
          }

    }

     /**
      *Metodo que sube la imagen 
      *y luego genera las distintas imagenes necesarias para la aplicación 
      *@deprecated
      */  
      
    public function uploadFoto()
    {
        if ($this->validate()) {
            
             $carpeta='assets/apps/'.$this->idApp.'/imgs/';
             $fileName='logo.'.$this->imageFile->extension;
          
           if(FileManager::uploadImgFile($carpeta,$fileName,$this->imageFile)){
                 $this->urlLogo= $carpeta. $fileName;
                $pathLogo16='assets/apps/'.$this->idApp.'/imgs/logo_16.png';
                $pathLogo42='assets/apps/'.$this->idApp.'/imgs/logo_42.png';
                $pathLogo94='assets/apps/'.$this->idApp.'/imgs/logo_94.png';
                $pathLogo300='assets/apps/'.$this->idApp.'/imgs/logo_300.png';

                FileManager::copyResizeImage($this->urlLogo,$pathLogo16,16);
                FileManager::copyResizeImage($this->urlLogo,$pathLogo42,42);
                FileManager::copyResizeImage($this->urlLogo,$pathLogo94,94);
                FileManager::copyResizeImage($this->urlLogo,$pathLogo300,300);

             return true;
            };


        }
        else{
            return false;
        }
    }

    
    /**
     * Devuelve un ActiveQuery con todos los usuario invitados de la aplicacion
     */
    public function getInvitados(){
        $query=Invitado::find()->where(['app_idApp'=>$this->idApp ]); 
         $dataProvider = new ActiveDataProvider([
             'query' => $query,
             'pagination'=>false,
         ]);
         return $dataProvider;
 
     }


     //---------------Funciones estaticas

     /**
      * Devuelve una lista de rubros disponibles
      *@return array matriz del tipo [key=>value]
      */
    public static function getRubros(){
         return[
         'ACCESORIOS_PERSONALES'=>'Joyerías, Perfumerías, Regalería',
         'AGROSERVICIOS'=>'Agro servicios, venta de insumos',
         'BAR'=>'Bar y restorant','DISTRIBUIDORA'=>'Distribuidora de productos',
         'CARNICERIA'=>'Carniceria y chacinados',
         'CONCESIONARIA'=>'Venta de motos y accesorios',
         'FERRETERIA'=>'Corralones. ferreteria',
         'GRAFICA'=>'Imprenta, copisteria, gráfica publicitaria',
         'KIOSCO'=>'Kioscos y Maxikioscos',
         'MERCERIA'=>'Locales de ropa y de moda, Merceria',
         'OPTICA'=>'Ópticas y fotografías',
         'PANADERIA'=>'Panaderia reposteria',
         'PELUQUERIA'=>'Peluquerías y barberías',
         'PINTURERIA'=>'Pinturerías',
         'SEVICIO_TECNICO'=>'Ventas y servicio técnico',
         'TALLER_MECANICO'=>'Taller mecánico y mantenimieto',
         'VENTA_SERVICIO'=>'Ventas de productos y servicio',
         'VERDULERIA'=>'Verduleria',   
     
     ];
     }
    

   
}
