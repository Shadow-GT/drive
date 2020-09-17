<?php

namespace Zenteno\Http;


class UploadFile
{
    private $gclient;

    public function __construct($client_id, $secret_client, $path_redirection)
    {
        $client = new \Zenteno\Http\Gclient();
        $this->gclient = $client->conection($client_id, $secret_client, $path_redirection);
    }

    public function uploadFile($name_file, $file_path, $folder_path = null)
    {
        $service = new \Google_Service_Drive($this->gclient);
        $file = new \Google_Service_Drive_DriveFile();

        $file->setName($name_file);
        $file->setDescription('A test document');
        $file->setMimeType('application/pdf');
        $file->setParents(array($folder_path));
        $data = file_get_contents($file_path);
        $service->files->create($file, array(
            'data' => $data,
            'mimeType' => 'application/pdf',
            'uploadType' => 'multipart'
        ));

        return true;
    }

    public function createFolder($name = null)
    {
        if ($name == null){
            $name = 'Folder';
        }

        $service = new \Google_Service_Drive($this->gclient);

        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => $name,
            'mimeType' => 'application/vnd.google-apps.folder'));


        $folder = $service->files->create($fileMetadata, array('fields' => 'id'));

        return $folder->id;
    }

    public function findFileInsideAFolder($folder_id, $file_name)
    {
        $service = new \Google_Service_Drive($this->gclient);
        $dev = $service->files->listFiles(array('q' => "'$folder_id' in parents"));

        foreach ($dev["files"] as $d){
            if ($d['name'] == $file_name){
                return true;
            }
        }

        return false;
    }


}