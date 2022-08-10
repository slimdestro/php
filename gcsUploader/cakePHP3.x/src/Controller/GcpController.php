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
