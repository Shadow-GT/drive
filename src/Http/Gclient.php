<?php

namespace Zenteno\Http;

class Gclient
{
    private $gclient;

    public function __construct()
    {
        $this->gclient = new \Google_Client();
    }

    public function conection($client_id, $secret_client, $path_redirection)
    {
        $this->gclient->setClientId($client_id);
        $this->gclient->setClientSecret($secret_client);
        $this->gclient->setRedirectUri($path_redirection);
        $this->gclient->setAccessType('offline');
        $this->gclient->setScopes([
                    \Google_Service_Drive::DRIVE_FILE,
                    \Google_Service_Drive::DRIVE_READONLY,
                    \Google_Service_Drive::DRIVE
                ]
        );


        session_start();

        if (isset($_GET['code']) || (isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
            if (isset($_GET['code'])) {
                $this->gclient->authenticate($_GET['code']);
                $_SESSION['access_token'] = $this->gclient->getAccessToken();
                file_put_contents('token/token.json', json_encode($this->gclient->getAccessToken()));
            } else{
                $this->gclient->setAccessToken($_SESSION['access_token']);
                file_put_contents('token/token.json', json_encode($_SESSION['access_token']));
            }
        }


       if ($this->gclient->isAccessTokenExpired()){
            $accessToken = json_decode(file_get_contents('token/token.json'), true);
            $this->gclient->setAccessToken($accessToken);
            $this->gclient->fetchAccessTokenWithRefreshToken($this->gclient->getRefreshToken());
            file_put_contents('token/token.json', json_encode($this->gclient->getAccessToken()));
        }


        return $this->gclient;
    }


}
