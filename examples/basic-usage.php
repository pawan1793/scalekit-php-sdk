<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Scalekit\ScalekitClient;

// Initialize the client
$client = new ScalekitClient(
    'https://your-environment.scalekit.cloud',
    'your-client-id',
    'your-client-secret'
);

try {
    // Get access token
    $tokenResponse = $client->auth->getAccessToken();
    echo "Access token obtained successfully\n";

    // List organizations
    $organizations = $client->organizations->listOrganizations(['page_size' => 5]);
    echo "Found " . count($organizations['organizations']) . " organizations\n";

    // Create a new organization
    $newOrg = $client->organizations->createOrganization([
        'display_name' => 'Test Organization',
        'region_code' => 'US',
        'metadata' => [
            'industry' => 'Technology'
        ]
    ]);
    echo "Created organization: " . $newOrg['organization']['id'] . "\n";

    // Generate SSO authorization URL
    $authUrl = $client->sso->getAuthorizationUrl([
        'redirect_uri' => 'https://your-app.com/callback',
        'organization_id' => $newOrg['organization']['id'],
        'scope' => 'openid email profile'
    ]);
    echo "SSO Authorization URL: " . $authUrl . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 