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
    // List organizations with pagination
    $organizations = $client->organizations->listOrganizations([
        'page_size' => 10
    ]);
    
    echo "Total organizations: " . $organizations['total_size'] . "\n";
    
    foreach ($organizations['organizations'] as $org) {
        echo "- " . $org['display_name'] . " (ID: " . $org['id'] . ")\n";
    }
    
    // Create new organization
    $newOrg = $client->organizations->createOrganization([
        'display_name' => 'Acme Corporation',
        'region_code' => 'US',
        'metadata' => [
            'industry' => 'Technology',
            'size' => 'Enterprise'
        ]
    ]);
    
    echo "Created organization: " . $newOrg['organization']['id'] . "\n";
    
    // Update organization
    $updatedOrg = $client->organizations->updateOrganization(
        $newOrg['organization']['id'],
        [
            'display_name' => 'Acme Corporation Updated',
            'metadata' => [
                'industry' => 'Technology',
                'size' => 'Enterprise',
                'updated_at' => date('c')
            ]
        ]
    );
    
    echo "Updated organization: " . $updatedOrg['organization']['display_name'] . "\n";
    
    // Get organization by ID
    $org = $client->organizations->getOrganization($newOrg['organization']['id']);
    echo "Retrieved organization: " . $org['organization']['display_name'] . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 