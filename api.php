<?php
// api.php - Sole function handler for AI generation requests

// Include configuration
require_once 'config.php';

// Set headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Main request handler function
function handleRequest() {
    // Check if request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return ['success' => false, 'error' => 'Only POST requests are allowed', 'code' => 405];
    }

    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || !isset($input['action'])) {
        return ['success' => false, 'error' => 'Invalid request format', 'code' => 400];
    }

    $action = $input['action'];

    // Route to appropriate handler
    switch ($action) {
        case 'generateImage':
            return handleImageGeneration($input);
        case 'generateVideo':
            return handleVideoGeneration($input);
        default:
            return ['success' => false, 'error' => 'Invalid action specified', 'code' => 400];
    }
}

// Image generation handler
function handleImageGeneration($input) {
    // Validate input
    if (!isset($input['prompt']) || empty(trim($input['prompt']))) {
        return ['success' => false, 'error' => 'Prompt is required', 'code' => 400];
    }

    $prompt = filter_var(trim($input['prompt']), FILTER_SANITIZE_STRING);
    $style = isset($input['style']) ? filter_var($input['style'], FILTER_SANITIZE_STRING) : DEFAULT_STYLE;
    $width = isset($input['width']) ? min((int)$input['width'], MAX_IMAGE_SIZE) : MAX_IMAGE_SIZE;
    $height = isset($input['height']) ? min((int)$input['height'], MAX_IMAGE_SIZE) : MAX_IMAGE_SIZE;

    // Prepare API request data
    $data = [
        'prompt' => $prompt,
        'style' => $style,
        'width' => $width,
        'height' => $height,
        'num_images' => 1
    ];

    // Call Runware AI API
    return callRunwareAPI(RUNWARE_IMAGE_API, $data);
}

// Video generation handler
function handleVideoGeneration($input) {
    // Validate input
    if (!isset($input['prompt']) || empty(trim($input['prompt']))) {
        return ['success' => false, 'error' => 'Prompt is required', 'code' => 400];
    }

    $prompt = filter_var(trim($input['prompt']), FILTER_SANITIZE_STRING);
    $duration = isset($input['duration']) ? min((int)$input['duration'], MAX_VIDEO_DURATION) : 5;

    // Prepare API request data
    $data = [
        'prompt' => $prompt,
        'duration' => $duration,
        'resolution' => '512x512'
    ];

    // Call Runware AI API
    return callRunwareAPI(RUNWARE_VIDEO_API, $data);
}

// Function to call Runware AI API
function callRunwareAPI($url, $data) {
    // Check if API key is configured
    if (empty(RUNWARE_API_KEY) || RUNWARE_API_KEY === 'your_actual_api_key_here') {
        return ['success' => false, 'error' => 'API key not configured', 'code' => 500];
    }

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 120); // Increased timeout for video generation
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . RUNWARE_API_KEY
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    
    curl_close($ch);
    
    if ($curl_error) {
        return ['success' => false, 'error' => 'Curl error: ' . $curl_error, 'code' => 500];
    }
    
    if ($http_code != 200) {
        return ['success' => false, 'error' => 'API request failed with code: ' . $http_code, 'code' => $http_code];
    }
    
    $response_data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['success' => false, 'error' => 'Invalid JSON response from API', 'code' => 500];
    }
    
    return ['success' => true, 'data' => $response_data, 'code' => 200];
}

// Execute the request handler
$response = handleRequest();

// Set appropriate HTTP status code
http_response_code(isset($response['code']) ? $response['code'] : 200);

// Remove code from response before sending
if (isset($response['code'])) {
    unset($response['code']);
}

echo json_encode($response);
exit;
?>