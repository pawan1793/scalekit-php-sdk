<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Scalekit\ScalekitClient;

$client = new ScalekitClient(
    'https://your-environment.scalekit.cloud',
    'your-client-id',
    'your-client-secret'
);

// Step 1: Get access token
$client->auth->getAccessToken();

// Step 2: Generate authorization URL for SSO
$authUrl = $client->sso->getAuthorizationUrl([
    'redirect_uri' => 'https://your-app.com/callback',
    'organization_id' => 'org_123',
    'scope' => 'openid email profile'
]);

echo "Redirect user to: " . $authUrl . "\n";

// Step 3: After user authentication, handle the callback
// In your callback handler:
if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $redirectUri = 'https://your-app.com/callback';
    
    try {
        $tokenResponse = $client->sso->exchangeCodeForToken($code, $redirectUri);
        
        // Get user info
        $userInfo = $client->auth->getUserInfo();
        
        echo "User authenticated: " . $userInfo['email'] . "\n";
    } catch (Exception $e) {
        echo "Authentication failed: " . $e->getMessage() . "\n";
    }
} 