<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Runware AI API configuration
define('RUNWARE_API_KEY', 'YOUR_API_KEY_HERE'); // Replace with actual API key
define('RUNWARE_IMAGE_API', 'https://api.runware.ai/v1/images/generate');
define('RUNWARE_VIDEO_API', 'https://api.runware.ai/v1/videos/generate');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Only POST requests are allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['action'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid request format']);
    exit;
}

$action = $input['action'];

// Handle image generation request
if ($action == 'generateImage') {
    if (!isset($input['prompt']) || empty($input['prompt'])) {
        echo json_encode(['success' => false, 'error' => 'Prompt is required']);
        exit;
    }
    
    $prompt = filter_var($input['prompt'], FILTER_SANITIZE_STRING);
    $style = isset($input['style']) ? filter_var($input['style'], FILTER_SANITIZE_STRING) : 'realistic';
    
    // Prepare API request data
    $data = [
        'prompt' => $prompt,
        'style' => $style,
        'width' => 512,
        'height' => 512,
        'num_images' => 1
    ];
    
    // Call Runware AI API
    $response = callRunwareAPI(RUNWARE_IMAGE_API, $data);
    
    // Return the response
    echo json_encode($response);
    exit;
}

// Handle video generation request
if ($action == 'generateVideo') {
    if (!isset($input['prompt']) || empty($input['prompt'])) {
        echo json_encode(['success' => false, 'error' => 'Prompt is required']);
        exit;
    }
    
    $prompt = filter_var($input['prompt'], FILTER_SANITIZE_STRING);
    $duration = isset($input['duration']) ? (int)$input['duration'] : 5;
    
    // Prepare API request data
    $data = [
        'prompt' => $prompt,
        'duration' => $duration,
        'resolution' => '512x512'
    ];
    
    // Call Runware AI API
    $response = callRunwareAPI(RUNWARE_VIDEO_API, $data);
    
    // Return the response
    echo json_encode($response);
    exit;
}

// Function to call Runware AI API
function callRunwareAPI($url, $data) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . RUNWARE_API_KEY
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        return ['success' => false, 'error' => 'Curl error: ' . curl_error($ch)];
    }
    
    curl_close($ch);
    
    if ($http_code != 200) {
        return ['success' => false, 'error' => 'API request failed with code: ' . $http_code];
    }
    
    $response_data = json_decode($response, true);
    
    return ['success' => true, 'data' => $response_data];
}

// If no valid action specified
echo json_encode(['success' => false, 'error' => 'Invalid action specified']);
exit;
?>