<?php

namespace BFOS\SyncContentBundle;

use BFOS\SyncContentBundle\Loader\LoaderInterface;
use BFOS\SyncContentBundle\Server\Server;

class Manager {
    /**
     * @var array
     */
    protected $servers;

    /**
     * List of options
     * @var array
     */
    protected $options;

    /**
     * Server loader
     * @var \BFOS\SyncContentBundle\Loader\LoaderInterface
     */
    protected $loader;

    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function loadServers($filename)
    {
        $servers = $this->loader->load($filename);

        if (null === $servers) {
            return;
        }

        $this->setServers($servers);
    }


    /**
     * Add a server to the list
     *
     * @param string $name
     * @param Server $server
     *
     * @return Manager
     */
    public function addServer($name, $server)
    {
        if (null === $server) {
            throw new \InvalidArgumentException('The server can not be null.');
        }

        if (isset($this->servers[$name])) {
            throw new \InvalidArgumentException(sprintf('The server "%s" is already registered.', $name));
        }

        $this->servers[$name] = $server;

        return $this;
    }

    /**
     * Add a list of servers
     *
     * @param array $servers
     *
     * @return Manager
     */
    public function setServers(array $servers)
    {
        foreach ($servers as $name => $server) {
            $this->addServer($name, $server);
        }

        return $this;
    }

    /**
     * Remove a server
     *
     * @param string $name
     *
     * @return Manager
     */
    public function removeServer($name)
    {
        unset($this->servers[$name]);

        return $this;
    }

    /**
     * Returns a server
     *
     * @param type $server The server name
     *
     * @return \BFOS\SyncContentBundle\Server\ServerInterface
     */
    public function getServer($server)
    {
        if (!isset($this->servers[$server])) {
            throw new \InvalidArgumentException(sprintf('The server "%s" is not registered.', $server));
        }

        return $this->servers[$server];
    }

    /**
     * Returns servers
     *
     * @return array
     */
    public function getServers()
    {
        return $this->servers;
    }


    /**
     * Deploy to the server using the deployer
     *
     * @param string $server
     * @param string $deployer
     * @param array  $options
     */
    public function synchronize($server, $options = array())
    {
        $server   = $this->getServer($server);

        return '';
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Add an option
     *
     * @param string $key
     * @param string $value
     */
    public function addOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * Returns options
     */
    public function getOptions()
    {
        return $this->options;
    }

}