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
    $connectionId = 'conn_456';
    
    // Send passwordless authentication
    $sendResult = $client->authMethods->sendPasswordless($organizationId, [
        'email' => 'user@example.com',
        'connection_id' => $connectionId
    ]);
    
    echo "Passwordless authentication sent to: user@example.com\n";
    
    // In a real application, the user would receive the code via email
    // and enter it in your application
    
    // Verify passwordless authentication (simulated)
    $verificationCode = '123456'; // This would come from user input
    
    $verifyResult = $client->authMethods->verifyPasswordless($organizationId, [
        'email' => 'user@example.com',
        'code' => $verificationCode
    ]);
    
    echo "Passwordless authentication verified: " . ($verifyResult['verified'] ? 'Success' : 'Failed') . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 