<?php
// api.php - Updated for new Runware API format

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

    // Get input data
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
    
    if (strpos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents('php://input'), true);
    } else {
        $input = $_POST;
    }

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

// Image generation handler - UPDATED FORMAT
function handleImageGeneration($input) {
    // Validate input
    if (!isset($input['prompt']) || empty(trim($input['prompt']))) {
        return ['success' => false, 'error' => 'Prompt is required', 'code' => 400];
    }

    $prompt = filter_var(trim($input['prompt']), FILTER_SANITIZE_STRING);
    $model = isset($input['model']) ? filter_var($input['model'], FILTER_SANITIZE_STRING) : 'runware:101@1';
    $width = isset($input['width']) ? (int)$input['width'] : 1024;
    $height = isset($input['height']) ? (int)$input['height'] : 1024;
    $steps = isset($input['steps']) ? (int)$input['steps'] : 30;

    // Generate unique task UUID
    $taskUUID = generateUUID();

    // Prepare API request data in NEW format
    $data = [
        [
            "taskType" => "imageInference",
            "taskUUID" => $taskUUID,
            "model" => $model,
            "positivePrompt" => $prompt,
            "width" => $width,
            "height" => $height,
            "steps" => $steps
        ]
    ];

    // Call Runware AI API
    return callRunwareAPI('https://api.runware.ai/v1', $data);
}

// Video generation handler - UPDATED FORMAT
function handleVideoGeneration($input) {
    // Validate input
    if (!isset($input['prompt']) || empty(trim($input['prompt']))) {
        return ['success' => false, 'error' => 'Prompt is required', 'code' => 400];
    }

    $prompt = filter_var(trim($input['prompt']), FILTER_SANITIZE_STRING);
    $model = isset($input['model']) ? filter_var($input['model'], FILTER_SANITIZE_STRING) : 'klingai:5@3';
    $duration = isset($input['duration']) ? (int)$input['duration'] : 10;
    $width = isset($input['width']) ? (int)$input['width'] : 1920;
    $height = isset($input['height']) ? (int)$input['height'] : 1080;
    $seed = isset($input['seed']) ? (int)$input['seed'] : rand(1, 1000);
    $numberResults = isset($input['numberResults']) ? (int)$input['numberResults'] : 1;

    // Generate unique task UUID
    $taskUUID = generateUUID();

    // Prepare API request data in NEW format
    $data = [
        "taskType" => "videoInference",
        "taskUUID" => $taskUUID,
        "positivePrompt" => $prompt,
        "model" => $model,
        "duration" => $duration,
        "width" => $width,
        "height" => $height,
        "seed" => $seed,
        "numberResults" => $numberResults
    ];

    // Call Runware AI API
    return callRunwareAPI('https://api.runware.ai/v1', $data);
}

// Generate UUID function
function generateUUID() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
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