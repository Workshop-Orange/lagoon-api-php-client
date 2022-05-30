<?php namespace WorkshopOrange\LagoonApiPhpClient;

trait ClientLoggerTrait {
    public function error($string) 
    {
        if($this->logger) {
            $this->logger->error($string);
        }
    }

    public function warning($string) 
    {
        if($this->logger) {
            $this->logger->warning($string);
        }
    }
    
    public function notice($string) 
    {
        if($this->logger) {
            $this->logger->notice($string);
        }
    }
    
    public function info($string) 
    {
        if($this->logger) {
            $this->logger->info($string);
        }
    }
    
    public function debug($string) 
    {
        if($this->logger) {
            $this->logger->debug($string);
        }
    }
}