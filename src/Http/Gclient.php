<?php

namespace Zenteno\Http;

class Gclient
{
    private $gclient;

    public function __construct()
    {
        $this->gclient = new \Google_Client();
    }

    public function conection($secret_client, $client_id, $path_redirection)
    {
        $this->gclient->setClientId($secret_client);
        $this->gclient->setClientSecret($client_id);
        $this->gclient->setRedirectUri($path_redirection);
        $this->gclient->setScopes(array('https://www.googleapis.com/auth/drive.file'));
        $code = isset($_GET['code']) ? $_GET['code'] : NULL;
        $token = $this->gclient->fetchAccessTokenWithAuthCode($code);
        $this->gclient->setAccessToken($token);
        file_put_contents('token/token.json', json_encode($this->gclient->getAccessToken()));

        return $this->gclient;
    }


}
