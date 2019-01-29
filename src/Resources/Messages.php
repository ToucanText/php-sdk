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
     * @param  bool  $ackMessages
     * @param  int  $maxMessageCount
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all($ackMessages = false, $maxMessageCount = 25)
    {
        $params = [
            'accountname' => $this->client->getUsername(),
            'password' => $this->client->getPassword(),
            'maxmessagecount' => $maxMessageCount,
        ];

        if ($ackMessages == true)
            $params['ACKMESSAGES'] = 'true';

        $query = http_build_query($params);

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api2.toucantext.com/api/messages.json?' . urldecode($query));

        return $response->getBody();
    }

    /**
     * Get the specified messages (inbound OR delivery receipts) only
     *
     * @param  string  $messageType
     * @param  bool  $ackMessages
     * @param  int  $maxMessageCount
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($messageType = null, $ackMessages = false, $maxMessageCount = 25)
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

        if ($ackMessages == true)
            $params['ACKMESSAGES'] = 'true';

        $query = http_build_query($params);

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api2.toucantext.com/api/messages.json?' . urldecode($query));

        return $response->getBody();
    }

    /**
     * Send a message using the ToucanText REST API
     *
     * @param  array  $message
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send($message = [])
    {
        if (!isset($message['destinationAddress']))
            throw new \Exception('Please specify a destination address');

        if (!isset($message['message']))
            throw new \Exception('Please specify a message');

        $params = [
            'USERNAME' => $this->client->getUsername(),
            'PASSWORD' => $this->client->getPassword(),
            'DESTADDR' => $message['destinationAddress'],
            'MESSAGE' => $message['message'],
        ];

        if (isset($message['sourceAddress']))
            $params['SOURCEADDR'] = $message['sourceAddress'];

        if (isset($message['deliveryReceipt']) && $message['deliveryReceipt'] == true)
            $params['DLR'] = true;

        $query = http_build_query($params);

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.toucantext.com/bin/send.json?' . urldecode($query));

        return $response->getBody();
    }
}
