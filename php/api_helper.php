<?php
class ApiHelper {
    private $base_url;
    private $token;

    public function __construct() {
        // Get the server protocol (http or https)
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        
        // Get the server name
        $server_name = $_SERVER['SERVER_NAME'];
        
        // Get the folder path
        $folder_path = '/SYSTEM-SA-MGA-GWAPO';
        
        // Construct the base URL
        $this->base_url = "{$protocol}://{$server_name}{$folder_path}/api/v1";
        $this->token = isset($_SESSION['token']) ? $_SESSION['token'] : null;
    }

    public function makeRequest($endpoint, $method = 'GET', $data = null) {
        $ch = curl_init($this->base_url . $endpoint);
        
        $headers = ['Content-Type: application/json'];
        if ($this->token) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local development
        
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            error_log('Curl error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        return [
            'code' => $httpCode,
            'response' => json_decode($response, true)
        ];
    }

    public function login($username, $password) {
        $result = $this->makeRequest('/auth/login', 'POST', [
            'username' => $username,
            'password' => $password
        ]);

        if ($result['code'] === 200 && isset($result['response']['data']['token'])) {
            $_SESSION['token'] = $result['response']['data']['token'];
            $_SESSION['user'] = $result['response']['data']['user'];
            $this->token = $result['response']['data']['token'];
            return true;
        }
        return false;
    }

    public function register($username, $email, $password) {
        return $this->makeRequest('/auth/register', 'POST', [
            'username' => $username,
            'email' => $email,
            'password' => $password
        ]);
    }

    public function logout() {
        unset($_SESSION['token']);
        unset($_SESSION['user']);
        $this->token = null;
        return $this->makeRequest('/auth/logout', 'POST');
    }

    public function getProducts() {
        return $this->makeRequest('/products', 'GET');
    }

    public function getProduct($id) {
        return $this->makeRequest("/products/$id", 'GET');
    }

    public function createOrder($items) {
        return $this->makeRequest('/orders', 'POST', [
            'items' => $items
        ]);
    }

    public function getOrders() {
        return $this->makeRequest('/orders', 'GET');
    }

    public function getOrder($id) {
        return $this->makeRequest("/orders/$id", 'GET');
    }

    public function isAdmin() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    public function getCurrentUser() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
} 