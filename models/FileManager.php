<?php
namespace app\models;

class FileManager{
    public static  function uploadFile($idApp,$imageFile){
    
        if ($idApp) {
            $carpeta='data/'.$idApp.'/';
            
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $imageFile->saveAs($carpeta. $imageFile->baseName . '.' . $imageFile->extension,false);
            $urlFile=$carpeta. $imageFile->baseName . '.' . $imageFile->extension;
            return $urlFile;
        } else {
           
            return false;
        }
    }

    public static  function uploadImgFile($carpeta,$fileName,$imageFile){
    
        if ($imageFile) {
           
            
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $imageFile->saveAs($carpeta.$fileName);

           
            return true;
        } else {
           
            return false;
        }
    }

    public static function copyResizeImage($fichero, $nuevo_fichero,$maxDim=800){

        if (!copy($fichero, $nuevo_fichero)) {
            FileManager::resizeImage($nuevo_fichero,$maxDim);
        }else{
             echo "Error al copiar $fichero...\n";
        }
    }

    public static function resizeImage($openPath,$maxDim=800){

               
        $file_name = $openPath;
        list($width, $height, $type, $attr) = getimagesize( $file_name );
        if ( $width > $maxDim || $height > $maxDim ) {
            $target_filename = $file_name;
            $ratio = $width/$height;
            if( $ratio > 1) {
                $new_width = $maxDim;
                $new_height = $maxDim/$ratio;
            } else {
                $new_width = $maxDim*$ratio;
                $new_height = $maxDim;
            }
            $src = imagecreatefromstring( file_get_contents( $file_name ) );
            $dst = imagecreatetruecolor( $new_width, $new_height );
            imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
            imagedestroy( $src );
            imagepng( $dst, $openPath); // adjust format as needed
            imagedestroy( $dst );
        }

   }


}
?>