<?php namespace WorkshopOrange\LagoonApiPhpClient;

trait ClientLoginTrait 
{
    public function login(bool $forceRefresh = false): bool
    {
        if($this->getApiToken() && !$forceRefresh) {
            $this->info("Existing token set: " . $this->getApiToken());
            return true;
        }

        $this->info("Logging in to lagoon " . $this->apiSshHostname . ":" . $this->apiSshPort);
        
        $command = sprintf('ssh -p %d -o LogLevel=ERROR -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -t lagoon@%s token 2>&1',
            $this->apiSshPort, $this->apiSshHostname);

        exec($command, $tokenArray, $returnValue);

        if ($returnValue !== 0) {
            $this->apiToken = null;
            throw new \Exception("Could not load API JWT Token: " . implode(",", $tokenArray));
        }

        return $this->setApiToken($tokenArray[0]);
    }
}