<?php

namespace Scalekit;

use Scalekit\Services\AuthService;
use Scalekit\Services\ClientService;
use Scalekit\Services\OrganizationService;
use Scalekit\Services\DirectoryService;
use Scalekit\Services\ConnectionService;
use Scalekit\Services\UserService;
use Scalekit\Services\AuthMethodsService;
use Scalekit\Services\M2MService;
use Scalekit\Services\JWKSService;
use Scalekit\Services\OpenIDService;
use Scalekit\Services\SSOService;
use Scalekit\Services\AdminPortalService;
use GuzzleHttp\Client as HttpClient;

/**
 * Main Scalekit client class
 */
class ScalekitClient
{
    private string $baseUrl;
    private string $clientId;
    private string $clientSecret;
    private ?string $accessToken = null;
    private HttpClient $httpClient;
    
    // Service instances
    public AuthService $auth;
    public ClientService $clients;
    public OrganizationService $organizations;
    public DirectoryService $directories;
    public ConnectionService $connections;
    public UserService $users;
    public AuthMethodsService $authMethods;
    public M2MService $m2m;
    public JWKSService $jwks;
    public OpenIDService $openid;
    public SSOService $sso;
    public AdminPortalService $adminPortal;

    public function __construct(
        string $baseUrl,
        string $clientId,
        string $clientSecret,
        array $config = []
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        
        $this->httpClient = new HttpClient(array_merge([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'headers' => [
                'User-Agent' => 'Scalekit-PHP-SDK/1.0.0',
                'Content-Type' => 'application/json',
            ]
        ], $config));
        
        // Initialize services
        $this->auth = new AuthService($this);
        $this->clients = new ClientService($this);
        $this->organizations = new OrganizationService($this);
        $this->directories = new DirectoryService($this);
        $this->connections = new ConnectionService($this);
        $this->users = new UserService($this);
        $this->authMethods = new AuthMethodsService($this);
        $this->m2m = new M2MService($this);
        $this->jwks = new JWKSService($this);
        $this->openid = new OpenIDService($this);
        $this->sso = new SSOService($this);
        $this->adminPortal = new AdminPortalService($this);
    }

    /**
     * Get the HTTP client instance
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * Get the base URL
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Get the client ID
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * Get the client secret
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * Set the access token
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Get the access token
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * Make an authenticated request
     */
    public function request(string $method, string $uri, array $options = []): array
    {
        if ($this->accessToken) {
            $options['headers']['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        $response = $this->httpClient->request($method, $uri, $options);
        return json_decode($response->getBody()->getContents(), true);
    }
} 