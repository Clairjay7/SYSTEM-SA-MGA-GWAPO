<?php
// Test configuration
$API_URL = 'http://localhost/api/v1';

// Function to make API requests
function makeRequest($endpoint, $method = 'GET', $data = null, $token = null) {
    global $API_URL;
    
    $ch = curl_init($API_URL . $endpoint);
    
    $headers = ['Content-Type: application/json'];
    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'code' => $httpCode,
        'response' => json_decode($response, true)
    ];
}

// Test cases
echo "Running API tests...\n\n";

// Test 1: Login with admin credentials
echo "Test 1: Admin Login\n";
$loginResult = makeRequest('/auth/login', 'POST', [
    'username' => 'admin',
    'password' => '123'
]);
echo "Status Code: " . $loginResult['code'] . "\n";
echo "Response: " . json_encode($loginResult['response'], JSON_PRETTY_PRINT) . "\n\n";

if ($loginResult['code'] === 200) {
    $token = $loginResult['response']['data']['token'];
    
    // Test 2: Get all users (requires admin token)
    echo "Test 2: Get All Users\n";
    $usersResult = makeRequest('/users', 'GET', null, $token);
    echo "Status Code: " . $usersResult['code'] . "\n";
    echo "Response: " . json_encode($usersResult['response'], JSON_PRETTY_PRINT) . "\n\n";
    
    // Test 3: Create new user
    echo "Test 3: Create New User\n";
    $createResult = makeRequest('/auth/register', 'POST', [
        'username' => 'testuser',
        'email' => 'test@example.com',
        'password' => 'password123'
    ]);
    echo "Status Code: " . $createResult['code'] . "\n";
    echo "Response: " . json_encode($createResult['response'], JSON_PRETTY_PRINT) . "\n\n";
    
    // Test 4: Update user (requires admin token)
    if (isset($createResult['response']['data']['user']['id'])) {
        $userId = $createResult['response']['data']['user']['id'];
        echo "Test 4: Update User\n";
        $updateResult = makeRequest("/users/$userId", 'PUT', [
            'email' => 'updated@example.com'
        ], $token);
        echo "Status Code: " . $updateResult['code'] . "\n";
        echo "Response: " . json_encode($updateResult['response'], JSON_PRETTY_PRINT) . "\n\n";
        
        // Test 5: Delete user (requires admin token)
        echo "Test 5: Delete User\n";
        $deleteResult = makeRequest("/users/$userId", 'DELETE', null, $token);
        echo "Status Code: " . $deleteResult['code'] . "\n";
        echo "Response: " . json_encode($deleteResult['response'], JSON_PRETTY_PRINT) . "\n\n";
    }
}

echo "API tests completed.\n"; 