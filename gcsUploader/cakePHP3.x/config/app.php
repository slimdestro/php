<?php

use Cake\Cache\Engine\FileEngine;
use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;
use Cake\Error\ExceptionRenderer;
use Cake\Log\Engine\FileLog;
use Cake\Mailer\Transport\MailTransport;

return [
    'gcsRoot' =>'https://storage.googleapis.com',
    'gcsBucket' =>'add_your_bucket_name_here',
    'gcsAcl' => 'publicRead',
    'gscKeyPath' => 'path_to_json_key_file',
];
