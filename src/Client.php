<?php

namespace ToucanText;

use mysql_xdevapi\Exception;

class Client
{
    // Authentication Params
    private $username;
    private $password;

    /**
     * __get overloads the client with a property that will check if there is a resource for the given $method
     * which allows calls such as $toucan->messages->send() to be correctly routed to the appropriate handler
     */
    public function __get($method)
    {
        $potentialEndpointClass = 'ToucanText\Resources\\' . ucfirst($method);

        if (class_exists($potentialEndpointClass)) {
            // construct a resource object and pass in this client
            $resource = new $potentialEndpointClass($this);
            return $resource;
        }

        $trace = debug_backtrace();
        $message = 'Undefined property via __get(): ' . $method . ' in ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'];
        throw new Exceptions\InvalidResourceException($message);
    }

    /**
     * Create an instance of the SDK, passing a configuration for it to set up
     *
     * @param  array  $config
     *
     * @return $this
     */
    public function __construct($config = [])
    {
        if (isset($config['username'])) {
            $this->setClientUsername($config['username']);
        }

        if (isset($config['password'])) {
            $this->setClientPassword($config['password']);
        }

        return $this;
    }

    /**
     * Get the username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the client username for authentication calls
     *
     * @param  string  $username
     *
     * @return $this
     */
    public function setClientUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Set the client password for authentication calls
     *
     * @param  string  $password
     *
     * @return $this
     */
    public  function setClientPassword($password)
    {
        $this->password = $password;
        return $this;
    }
}
