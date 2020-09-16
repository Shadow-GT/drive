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
        $this->gclient->setScopes(array('https://www.googleapis.com/auth/drive.file'));

        session_start();

        if (isset($_GET['code']) || (isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
            if (isset($_GET['code'])) {
                $this->gclient->authenticate($_GET['code']);
                $_SESSION['access_token'] = $this->gclient->getAccessToken();
            } else{
                $this->gclient->setAccessToken($_SESSION['access_token']);
            }
        }

        return $this->gclient;
    }


}
