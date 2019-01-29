<?php

namespace ToucanText\Resources;

use mysql_xdevapi\Exception;

class Messages
{
    private $client;

    /**
     * Create an instance of the Messages resource, passing in an instance of the SDK instance
     *
     * @param  array  $client
     *
     * @return $this
     */
    public function __construct($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get ALL messages (inbound and delivery receipts) from the ToucanText API
     *
     * @param  int  $maxMessageCount
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all($maxMessageCount = 25)
    {
        $query = http_build_query([
            'accountname' => $this->client->getUsername(),
            'password' => $this->client->getPassword(),
            'maxmessagecount' => $maxMessageCount,
        ]);

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api2.toucantext.com/api/messages.json?' . urldecode($query));

        return $response->getBody();
    }

    /**
     * Get the specified messages (inbound OR delivery receipts) only
     *
     * @param  string  $messageType
     * @param  int  $maxMessageCount
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($messageType = null, $maxMessageCount = 25)
    {
        if (($messageType != 'messagesOnly' || $messageType != 'dlrsOnly') && $messageType == null) {
            throw new \Exception('Please specify a valid message type');
        }

        $params = [
            'accountname' => $this->client->getUsername(),
            'password' => $this->client->getPassword(),
            'maxmessagecount' => $maxMessageCount,
        ];

        if ($messageType == 'messagesOnly')
            $params['messagesonly'] = 'true';

        if ($messageType == 'dlrsOnly')
            $params['dlrsonly'] = 'true';

        $query = http_build_query($params);

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api2.toucantext.com/api/messages.json?' . urldecode($query));

        return $response->getBody();
    }

    public function send()
    {
        //
    }
}