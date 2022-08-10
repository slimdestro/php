<?php
/**
 * Author : Mukul Kumar
 * GitPage: https://github.com/slimdestro
 * Dated: 10th August 2021
 */
namespace App\Controller\Component; 

use Cake\Controller\Component;
use Cake\Core\Configure;
use Google\Cloud\Storage\StorageClient;

class GcsComponent extends Component { 
    
    /**
     * This method takes 'Directory' path as parameter
     */
    public function gcsUploadDirectory($dirPath){
        $stats = array(
            "uploadedFilesList" => array(), 
            "failedUploads" => array()
        );

        $iterablePath = array();
        foreach(scandir($dirPath) as $file){
            if(preg_match("[[\w,\s-]+\.[A-Za-z]{3}]", $file) != 0){
                array_push($iterablePath, $file);
            }
        }

        foreach($iterablePath as $uploadableFile){
            $size = round(filesize($dirPath. DIRECTORY_SEPARATOR. $uploadableFile) / 1000);
            if($size == 0){
                array_push($stats["failedUploads"], $uploadableFile);
            }else{ 
                $gcpPath = $this->gcsUploader($dirPath. DIRECTORY_SEPARATOR. $uploadableFile, $uploadableFile);
               
                array_push(
                    $stats["uploadedFilesList"], 
                    array($uploadableFile, $gcpPath)
                );
            }     
        }
        return $stats;
    }

    /**
     * gcsUploader uploads single object to GCS
     * $path is file location which is to be uploaded
     * @fileName is name of the file which will be visible in gm_images
    */
    public function gcsUploader($path, $fileName)
    { 
        if(file_get_contents($path) == ""){
            return "Invalid path";
        }

        if(count(explode(".", $fileName)) <= 1){
            return "Filename should have extension";
        }

        $finalPath = "";   
        try
        {
            $storage = new StorageClient([
                'keyFilePath' => Configure::read("gscKeyPath"),
            ]);
        
            $fName = $fileName;
            $bucket = $storage->bucket(Configure::read("gcsBucket"));
            $object = $bucket->upload( 
            file_get_contents($path),
            [
                'predefinedAcl' => Configure::read("gcsAcl"),
                'name' => $fName
            ] 
            );
            
            $finalPath = Configure::read("gcsRoot") .
                DIRECTORY_SEPARATOR. "my_personal_gcp_bucket" .
                DIRECTORY_SEPARATOR. $fName;
            return $finalPath;
        } 
        catch(\Exception $e) 
        {
            return $e->getMessage();
        }

    }
}






