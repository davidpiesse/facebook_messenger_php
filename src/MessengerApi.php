<?php
namespace mapdev\FacebookMessenger;

use GuzzleHttp\Client;

class MessengerApi
{
    protected $api_url = "https://graph.facebook.com/v2.6/";

    protected $token = null;

    protected $client;

    const GET = 'GET';
    const POST = 'POST';
    const DELETE = 'DELETE';

    public function __construct($token)
    {
        $this->client = new Client();
        $this->token = $token;
    }

    protected function checkToken()
    {
        return !is_null($this->token);
    }

    public function callApi($path, $data, $type = self::POST, $json = true)
    {
        if (!$this->checkToken())
            throw new \Exception('Invalid API Token');

        if ($json) {
            $response = $this->client->request($type, $this->api_url . $path, [
                'query' => ['access_token' => $this->token],
                'json' => $data
            ]);
        } else {
            $data['access_token'] = $this->token;
            $response = $this->client->request($type, $this->api_url . $path, [
                'query' => $data
            ]);
        }
        if ($response->getStatusCode() == 200)
            return json_decode($response->getBody());
        else
            throw new \Exception('Invalid Response');
    }

}