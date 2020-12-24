<?php
namespace app\models;

class ThemeApp
{
    /*
     * :root {
    --blue: #007bff;
    --indigo: #6610f2;
    --purple: #6f42c1;
    --pink: #e83e8c;
    --red: #dc3545;
    --orange: #fd7e14;
    --yellow: #ffc107;
    --green: #28a745;
    --teal: #20c997;
    --cyan: #17a2b8;
    --white: #fff;
    --gray: #6c757d;
    --gray-dark: #343a40;
    --primary: #f6648C; <---
    --secondary: #CACACA; <---
    --success: #035668; <---
    --info: #3F81C7; <-
    --warning: #0DE2EA; <-
    --danger: #FF444F; <-
    --light: #eAeAeA; <---
    --dark: #223322; <---
    --breakpoint-xs: 0;
    --breakpoint-sm: 576px;
    --breakpoint-md: 768px;
    --breakpoint-lg: 992px;
    --breakpoint-xl: 1200px;
    --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}
     */
   public  $color_primary='#10202c';
   public  $color_secondary='#10202c';
   public  $color_success='#c0c0c0';
   public  $color_light='rgb(19, 18, 18)';
   public  $color_dark='#07141d';
   public  $url_logo="";
   public  $url_membrete="";
   public  $font_primari='';            // fuente principal
   public  $font_secondary='';          // fuente secundaria
   private $idApp='';

   /**Constructor de la clase
    * 
    */
   public function __construct($idApp){
       if($idApp){
           $this->idApp=$idApp;
       }
       
   }

   /**
    * Metodo que setea el objeto con las matriz de estilos pasada
    *@param array $style matriz que contien los key correspondiente a las propiedades
    *@return boolean si falla la carga de estilo devuelve false
    */
   public function setStyle($style=[]){

        //verifica estrictamente si contiene todas las propiedades
       if($this->verificarStyle($style)){
           $this->color_primary=$style['color_primary'];
           $this->color_secondary=$style['color_secondary'];
           $this->color_success=$style['color_success'];
           $this->color_light=$style['color_light'];
           $this->color_dark=$style['color_dark'];
           $this->url_logo=$style['url-logo'];
           $this->url_membrete=$style['url_membrete'];
           $this->font_primary=$style['font_primary'];
           $this->font_secondary=$style['font_secondary'];
           return true;

       }else{
           return false;
       }

   }

    /**
     * Método que genera los archivos css de la aplicación
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
     * Genera los iconos necesarios para la aplicación
     * @return boolean devuelve falso si algun archivo no fue creado
     */
    public function generateIcons(){

    } 

    /**
     * Genera las imagenes que necesita la aplicación
     *  -Membretes para documentos
     *  -fondo de pantalla
     * @return boolean devuelve falso si algun archivo no fue creado
     */
    public function generateImgsDocs(){

    }





   /**
    * metodo que autentifica el formato del estilo pasado
    */
   private function verificarStyle($style){
       if(count($style)>0){
            if(isset($style['color_primary']) &&
              isset($style['color_secondary']) && 
              isset($style['color_success']) &&
              isset($style['color_light']) && 
              isset($style['color_dark']) &&
              isset($style['url_logo']) &&
              isset($style['url_membrete']) &&
              isset($style['font_primary']) &&
              isset($style['font_secondary'])  ){
                  return true;
              }
       }else{
           return false;
       }
   }

}
