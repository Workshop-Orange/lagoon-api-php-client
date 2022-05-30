<?php namespace WorkshopOrange\LagoonApiPhpClient;

use WorkshopOrange\LagoonApiPhpClient\Types\BaseType;

interface ClientInterface {
    public function registerType(string $type, BaseType $typeInstance);
    
    public function getApiToken() : ?string;
    public function setApiToken(string $token) : bool;

    public function error($string);
    public function warning($string);
    public function notice($string);
    public function info($string);
    public function debug($string);
}