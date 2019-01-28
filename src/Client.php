<?php

namespace ToucanText;

class Client
{
    // Authentication Params
    private $username;
    private $password;

    public function __get($name)
    {
        // TODO: Implement __get() method.
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
