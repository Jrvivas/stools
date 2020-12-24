<?php
namespace app\models;

class Util{
    /**
     * genera uan clave aleatoria con los parametros introducidos
     */
    public static function randKey($str='', $long=0)
    {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str)-1;
        for($x=0; $x<$long; $x++)
        {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }
/**
     * genera uan clave aleatoria con los parametros introducidos
     */
    public static function keyTime()
    {
        $hoy = date("YmdHis");   
        
        $key=Util::randKey("abcdef0123456789",16).'-'.strval($hoy);
      
        return $key;
    }

        /**
     * Funcion que reemplasa textos en archivo
     */
    public static function replace_string_in_file($filename, $string_to_replace, $replace_with){
        $content=file_get_contents($filename);
        $content_chunks=explode($string_to_replace, $content);
        $content=implode($replace_with, $content_chunks);
        file_put_contents($filename, $content);
    }

   
  
}