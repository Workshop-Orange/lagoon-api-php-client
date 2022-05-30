<?php namespace WorkshopOrange\LagoonApiPhpClient\Types;

use WorkshopOrange\LagoonApiPhpClient\ClientInterface;

abstract class BaseType 
{
    protected $client;
    protected $type;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function register(string $type): bool
    {
        $this->type = $type;
        return TRUE;
    }

    public function ping()
    {
        $this->client->debug($this->type . ": ping returns pong");
    }
}