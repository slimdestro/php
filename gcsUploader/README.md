# GCSUploader
#### Google cloud storage Component for CakePHPn 3.x
```sh
$this->loadComponent('Gcs') 

// Directory upload
$dir = "/my_directory_path";
$stats = $this->Gcs->gcsUploadDirectory($dir);
 
// single file upload 
$gcsPath = $this->Gcs->gcsUploader("/file_path", "file_name"); 
```

## Example

```sh
<?php
    namespace App\Controller;

    use App\Controller\AppController;

    class GcsController extends AppController
    {
        public function index()
        {
            $this->loadComponent('Gcs');

            // Directory upload
            $dir = "/my_directory_path";
            $stats = $this->Gcs->gcsUploadDirectory($dir);

            // single file upload 
            $gcsPath = $this->Gcs->gcsUploader("/file_path", "file_name");
        }
    }
?>
```


## Author

[slimdestro(Mukul Mishra)](https://linktr.ee/slimdestro)

