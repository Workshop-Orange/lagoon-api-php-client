<?php namespace WorkshopOrange\LagoonApiPhpClient;

use WorkshopOrange\LagoonApiPhpClient\Types\BaseType;
use WorkshopOrange\LagoonApiPhpClient\Types\BackupType;
use WorkshopOrange\LagoonApiPhpClient\Types\DeploymentType;
use WorkshopOrange\LagoonApiPhpClient\Types\EnvironmentType;
use WorkshopOrange\LagoonApiPhpClient\Types\GroupType;
use WorkshopOrange\LagoonApiPhpClient\Types\NotificationRocketchatType;
use WorkshopOrange\LagoonApiPhpClient\Types\NotificationSlackType;
use WorkshopOrange\LagoonApiPhpClient\Types\ProjectType;
use WorkshopOrange\LagoonApiPhpClient\Types\TaskType;
use WorkshopOrange\LagoonApiPhpClient\Types\UserType;
use WorkshopOrange\LagoonApiPhpClient\Types\VariableType;

use Psr\Log\LoggerInterface;

class Client implements ClientInterface
{
    protected $logger;
    protected $apiGraphqlEndpoint = "https://api.lagoon.amazeeio.cloud/graphql";
    protected $apiSshHostname = "ssh.lagoon.amazeeio.cloud";
    protected $apiSshPort = "32222";
    protected $apiToken = null;

    use ClientLoggerTrait;
    use ClientLoginTrait;
    use ClientHttpTrait;

    public function __construct(LoggerInterface $logger, string $apiToken = null)
    {
        $this->logger = $logger;

        if($apiToken) {
            $this->apiToken = $apiToken;
        }
        
        $this->registerType('backup', new BackupType($this));
        $this->registerType('deployment', new DeploymentType($this));
        $this->registerType('environment', new EnvironmentType($this));
        $this->registerType('group', new GroupType($this));
        $this->registerType('notificationRocketchat', new NotificationRocketchatType($this));
        $this->registerType('notificationSlack', new NotificationSlackType($this));
        $this->registerType('project', new ProjectType($this));
        $this->registerType('task', new TaskType($this));
        $this->registerType('user', new UserType($this));
        $this->registerType('variable', new VariableType($this));
    }

    public function registerType(string $type, BaseType $typeInstance) 
    {
        if($typeInstance->register($type)) {
            $this->debug("Register type: " . $type);
            $this->$type = $typeInstance;
        } else {
            $this->debug("Failed to register type: " . $type);
        }
    }

    public function getApiToken() : ?string 
    {
        return $this->apiToken;
    }

    public function setApiToken(string $token) : bool
    {
        $this->debug("Token: " . $token);
        $this->apiToken = $token;
        return true;
    }
}
