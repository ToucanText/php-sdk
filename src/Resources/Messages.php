<?php

namespace ToucanText\Resources;

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

    public function get()
    {
        //
    }

    public function send()
    {
        //
    }
}
