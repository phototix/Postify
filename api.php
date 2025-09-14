<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Runware AI API configuration
define('RUNWARE_API_KEY', 'SSE24g8y8wnZHB1M6lmMeDW7oFD08Qlr');
define('RUNWARE_IMAGE_API', 'https://api.runware.ai/v1/images/generate');
define('RUNWARE_VIDEO_API', 'https://api.runware.ai/v1/videos/generate');

// Handle image generation request
if ($_POST['action'] == 'generateImage') {
    $prompt = $_POST['prompt'];
    $style = $_POST['style'];
    
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
if ($_POST['action'] == 'generateVideo') {
    $prompt = $_POST['prompt'];
    $duration = $_POST['duration'];
    
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
echo json_encode(['success' => false