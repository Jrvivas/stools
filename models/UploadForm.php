<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $urlFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload($idApp)
    {
        if ($this->validate()) {
            $carpeta='data/'.$idApp.'/';
            
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $this->imageFile->saveAs($carpeta. $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->urlFile=$carpeta. $this->imageFile->baseName . '.' . $this->imageFile->extension;
            return true;
        } else {
            $this->urlFile='';
            return false;
        }
    }
}