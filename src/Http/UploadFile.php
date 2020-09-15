<?php

namespace Zenteno\Http;


class UploadFile
{
    private $gclient;

    public function __construct($secret_client, $client_id)
    {
        $client = new Gclient();
        $this->gclient = $client->conection($secret_client, $client_id);
    }

    public function uploadFile($name_file, $file_path, $folder_path = null)
    {
        $service = new \Google_Service_Drive($this->gclient);
        $file = new \Google_Service_Drive_DriveFile();

        $file->setName($name_file);
        $file->setDescription('A test document');
        $file->setMimeType('image/jpeg');
        $file->setParents(array($folder_path));
        $data = file_get_contents($file_path);
        $service->files->create($file, array(
            'data' => $data,
            'mimeType' => 'image/jpeg',
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
}