<?php

namespace Zenteno\Http;

class Gclient
{
    private $gclient;

    public function __construct($client_id, $secret_client, $path_redirection)
    {
        $client = new \Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($secret_client);
        $client->setRedirectUri($path_redirection);
        $client->setAccessType('offline');
        $client->setScopes([
                \Google_Service_Drive::DRIVE_FILE,
                \Google_Service_Drive::DRIVE_READONLY,
                \Google_Service_Drive::DRIVE
            ]
        );


        session_start();

        if (isset($_GET['code']) || (isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
            if (isset($_GET['code'])) {
                $client->authenticate($_GET['code']);
                $_SESSION['access_token'] = $client->getAccessToken();
                file_put_contents('token/token.json', json_encode($client->getAccessToken()));
            } else{
                $client->setAccessToken($_SESSION['access_token']);
                file_put_contents('token/token.json', json_encode($_SESSION['access_token']));
            }
        }


        if ($client->isAccessTokenExpired()){
            $accessToken = json_decode(file_get_contents('token/token.json'), true);
            $client->setAccessToken($accessToken);
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents('token/token.json', json_encode($client->getAccessToken()));
        }


        $this->gclient = $client;
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
