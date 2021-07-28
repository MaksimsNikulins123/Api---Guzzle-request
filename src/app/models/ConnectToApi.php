<?php

namespace App\models;

use GuzzleHttp\Client;

class ConnectToApi
{
    public function getResponse()
    {
        $client = new Client([
            'base_uri' => 'https://api.github.com',
            'timeout' => 2.0
        ]);
        $response = $client->request('GET', 'organizations');
        return $response;
    }
}
