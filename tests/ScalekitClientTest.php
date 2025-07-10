<?php

namespace Scalekit\Tests;

use PHPUnit\Framework\TestCase;
use Scalekit\ScalekitClient;

class ScalekitClientTest extends TestCase
{
    private ScalekitClient $client;

    protected function setUp(): void
    {
        $this->client = new ScalekitClient(
            'https://test.scalekit.cloud',
            'test-client-id',
            'test-client-secret'
        );
    }

    public function testClientInitialization()
    {
        $this->assertInstanceOf(ScalekitClient::class, $this->client);
        $this->assertEquals('https://test.scalekit.cloud', $this->client->getBaseUrl());
        $this->assertEquals('test-client-id', $this->client->getClientId());
        $this->assertEquals('test-client-secret', $this->client->getClientSecret());
    }

    public function testServicesAreInitialized()
    {
        $this->assertInstanceOf(\Scalekit\Services\AuthService::class, $this->client->auth);
        $this->assertInstanceOf(\Scalekit\Services\OrganizationService::class, $this->client->organizations);
        $this->assertInstanceOf(\Scalekit\Services\SSOService::class, $this->client->sso);
        $this->assertInstanceOf(\Scalekit\Services\DirectoryService::class, $this->client->directories);
        $this->assertInstanceOf(\Scalekit\Services\ConnectionService::class, $this->client->connections);
        $this->assertInstanceOf(\Scalekit\Services\UserService::class, $this->client->users);
        $this->assertInstanceOf(\Scalekit\Services\AuthMethodsService::class, $this->client->authMethods);
        $this->assertInstanceOf(\Scalekit\Services\M2MService::class, $this->client->m2m);
        $this->assertInstanceOf(\Scalekit\Services\JWKSService::class, $this->client->jwks);
        $this->assertInstanceOf(\Scalekit\Services\OpenIDService::class, $this->client->openid);
        $this->assertInstanceOf(\Scalekit\Services\AdminPortalService::class, $this->client->adminPortal);
        $this->assertInstanceOf(\Scalekit\Services\ClientService::class, $this->client->clients);
    }
} 