<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Scalekit\ScalekitClient;

$client = new ScalekitClient(
    'https://your-environment.scalekit.cloud',
    'your-client-id',
    'your-client-secret'
);

// Get access token
$client->auth->getAccessToken();

try {
    $organizationId = 'org_123';
    
    // Create M2M client
    $m2mClient = $client->m2m->createM2MClient($organizationId, [
        'name' => 'API Service Account',
    ]);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 