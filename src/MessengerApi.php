<?php
namespace mapdev\FacebookMessenger;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use mapdev\FacebookMessenger\Exceptions\CouldNotSendNotification;

class MessengerApi
{
    protected $api_url = "https://graph.facebook.com/v2.7/";

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
        if (!$this->checkToken()) {
            throw CouldNotSendNotification::invalidFacebookToken();
        }

        try {
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
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                throw CouldNotSendNotification::invalidStatusCode($response->getStatusCode());
            }
        } catch (ClientException $ex) {
            throw CouldNotSendNotification::facebookResponseError($ex);
        } catch (\Exception $ex) {
            throw CouldNotSendNotification::couldNotCommunicateWithFacebook($ex);
        }
    }
}