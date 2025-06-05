<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get request path
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim(str_replace('/api', '', $request_uri), '/');

// Include controllers
require_once __DIR__ . '/controllers/OrderController.php';

// Initialize controllers
$orderController = new OrderController();

// Route definitions
switch ($path) {
    // Order endpoints
    case 'order/create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderController->createOrder();
        } else {
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
        }
        break;

    case 'order/refund':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderController->processRefund();
        } else {
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint not found"]);
        break;
} 