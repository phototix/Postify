<?php
// config.php - Configuration file for API keys and settings

// Runware AI API configuration
define('RUNWARE_API_KEY', 'your_actual_api_key_here'); // Replace with your actual API key
define('RUNWARE_IMAGE_API', 'https://api.runware.ai/v1/images/generate');
define('RUNWARE_VIDEO_API', 'https://api.runware.ai/v1/videos/generate');

// Application settings
define('MAX_IMAGE_SIZE', 512);
define('MAX_VIDEO_DURATION', 15);
define('DEFAULT_STYLE', 'realistic');

// CORS settings
define('ALLOWED_ORIGINS', ['http://localhost', 'https://yourdomain.com']);
?>