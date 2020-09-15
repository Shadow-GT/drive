<?php

namespace Zenteno\Http;

class Gclient
{
    private $gclient;

    public function __construct()
    {
        $this->gclient = new \Google_Client();
    }

    public function conection($secret_client, $client_id)
    {
        $this->gclient->setClientId('46196560743-qp0d79fqo9k3l6720lvanc9gs4j18s9c.apps.googleusercontent.com');
        $this->gclient->setClientSecret('2SAuRqVaj9P5BHZ3Q6Knqymy');
        $this->gclient->setRedirectUri('http://drive.io');
        $this->gclient->setScopes(array('https://www.googleapis.com/auth/drive.file'));
        $code = isset($_GET['code']) ? $_GET['code'] : NULL;
        $token = $this->gclient->fetchAccessTokenWithAuthCode($code);
        $this->gclient->setAccessToken($token);
        file_put_contents('token/token.json', json_encode($this->gclient->getAccessToken()));

        return $this->gclient;
    }


}
