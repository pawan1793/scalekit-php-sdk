# Scalekit PHP SDK

PHP SDK for Scalekit - Enterprise Authentication Platform

## Installation

```bash
composer require pawanmore/scalekit-php-sdk
```

## Quick Start

```php
<?php

require_once 'vendor/autoload.php';

use Scalekit\ScalekitClient;

// Initialize the client
$client = new ScalekitClient(
    'https://your-environment.scalekit.cloud',
    'your-client-id',
    'your-client-secret'
);

// Get access token
$tokenResponse = $client->auth->getAccessToken();

// List organizations
$organizations = $client->organizations->listOrganizations();

// Create an organization
$newOrg = $client->organizations->createOrganization([
    'display_name' => 'My Organization',
    'region_code' => 'US'
]);
```

## Authentication

The SDK uses OAuth2 client credentials flow for authentication:

```php
// Get access token
$tokenResponse = $client->auth->getAccessToken();

// The token is automatically set and used for subsequent requests
```

## Available Services

### AuthService
- `getAccessToken()` - Get access token using client credentials
- `exchangeCodeForToken($code, $redirectUri)` - Exchange authorization code for token
- `refreshToken($refreshToken)` - Refresh access token
- `revokeToken($token)` - Revoke access token
- `introspectToken($token)` - Introspect token
- `getUserInfo()` - Get user info

### OrganizationService
- `listOrganizations($params)` - List organizations
- `searchOrganizations($params)` - Search organizations
- `createOrganization($data)` - Create organization
- `getOrganization($id)` - Get organization by ID
- `getOrganizationByExternalId($externalId)` - Get organization by external ID
- `updateOrganization($id, $data)` - Update organization
- `updateOrganizationSettings($id, $settings)` - Update organization settings
- `deleteOrganization($id)` - Delete organization

### SSOService
- `getAuthorizationUrl($params)` - Generate authorization URL for SSO
- `exchangeCodeForToken($code, $redirectUri)` - Exchange code for token

### DirectoryService
- `listDirectories($params)` - List all directories
- `getDirectory($id)` - Get directory
- `listUsersInDirectory($directoryId, $params)` - List users in directory
- `listGroupsInDirectory($directoryId, $params)` - List groups in directory
- `enableDirectory($id)` - Enable directory
- `disableDirectory($id)` - Disable directory

### ConnectionService
- `listConnections($organizationId, $params)` - List connections
- `getConnection($organizationId, $connectionId)` - Get connection
- `enableConnection($organizationId, $connectionId)` - Enable connection
- `getConnectionProviders()` - Get connection providers

### UserService
- `listUsers($organizationId, $params)` - List users in organization
- `createUser($organizationId, $userData)` - Create user

### AuthMethodsService
- `sendPasswordless($organizationId, $data)` - Send passwordless authentication
- `verifyPasswordless($organizationId, $data)` - Verify passwordless authentication
- `resendPasswordless($organizationId, $data)` - Resend passwordless authentication
- `createPasswordlessConnection($organizationId, $data)` - Create passwordless connection
- `updatePasswordlessConnection($organizationId, $connectionId, $data)` - Update passwordless connection
- `enablePasswordlessConnection($organizationId, $connectionId)` - Enable passwordless connection

### M2MService
- `createM2MClient($organizationId, $data)` - Create M2M client
- `createM2MClientSecret($organizationId, $clientId)` - Create M2M client secret
- `getM2MClient($organizationId, $clientId)` - Get M2M client
- `rotateSecret($organizationId, $clientId)` - Rotate M2M client secret
- `updateM2MClient($organizationId, $clientId, $data)` - Update M2M client details
- `getM2MClientAccessToken($clientId, $clientSecret)` - Get M2M client access token
- `deleteM2MClientSecret($organizationId, $clientId, $secretId)` - Delete M2M client secret
- `deleteM2MClient($organizationId, $clientId)` - Delete M2M client

### JWKSService
- `getJWKS()` - Get JSON Web Key Set

### OpenIDService
- `getConfiguration()` - Get OpenID configuration

### AdminPortalService
- `generatePortalLink($organizationId, $data)` - Generate admin portal link

### ClientService
- `getClient($clientId)` - Get client by ID
- `updateClientRedirects($clientId, $redirects)` - Update client redirects

## Examples

### Single Sign-On (SSO)

```php
// Generate authorization URL
$authUrl = $client->sso->getAuthorizationUrl([
    'redirect_uri' => 'https://your-app.com/callback',
    'organization_id' => 'org_123',
    'scope' => 'openid email profile'
]);

// After user authentication, exchange code for token
$tokenResponse = $client->sso->exchangeCodeForToken($code, $redirectUri);
```

### Organization Management

```php
// Create organization
$organization = $client->organizations->createOrganization([
    'display_name' => 'Acme Corp',
    'region_code' => 'US',
    'metadata' => [
        'industry' => 'Technology'
    ]
]);

// List organizations with pagination
$organizations = $client->organizations->listOrganizations(); 