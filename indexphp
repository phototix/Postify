<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialAI Post Generator</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6f42c1;
            --secondary: #20c997;
            --dark: #343a40;
            --light: #f8f9fa;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary);
        }
        
        .hero-section {
            background: linear-gradient(135deg, #6f42c1 0%, #6610f2 100%);
            color: white;
            padding: 4rem 0;
            border-radius: 0 0 2rem 2rem;
            margin-bottom: 3rem;
        }
        
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 2px solid var(--primary);
            font-weight: 600;
            border-radius: 1rem 1rem 0 0 !important;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: #5a32a3;
            border-color: #5a32a3;
        }
        
        .btn-success {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
        
        .result-container {
            display: none;
            margin-top: 2rem;
        }
        
        .preview-image, .preview-video {
            max-width: 100%;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        footer {
            background-color: var(--dark);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }
        
        .spinner-border {
            width: 3rem; 
            height: 3rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-robot me-2"></i>SocialAI Generator
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Create Stunning Social Media Content</h1>
            <p class="lead mb-4">Generate eye-catching images and videos for your social media posts using AI</p>
            <button class="btn btn-light btn-lg px-4">Get Started</button>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Image Generator -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header text-center py-3">
                        <i class="fas fa-image me-2"></i> AI Image Generator
                    </div>
                    <div class="card-body">
                        <form id="imageForm">
                            <div class="mb-3">
                                <label for="imagePrompt" class="form-label">Describe your image</label>
                                <textarea class="form-control" id="imagePrompt" rows="3" placeholder="E.g., A futuristic cityscape at sunset with flying cars" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imageStyle" class="form-label">Style</label>
                                <select class="form-select" id="imageStyle">
                                    <option value="realistic">Realistic</option>
                                    <option value="cartoon">Cartoon</option>
                                    <option value="abstract">Abstract</option>
                                    <option value="vintage">Vintage</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Generate Image</button>
                        </form>
                        
                        <div class="loading" id="imageLoading">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Generating your image... This may take a few seconds.</p>
                        </div>
                        
                        <div class="result-container" id="imageResult">
                            <h5 class="mb-3">Generated Image</h5>
                            <div class="text-center">
                                <img src="" class="preview-image mb-3" id="generatedImage" alt="Generated image">
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" id="downloadImage"><i class="fas fa-download me-2"></i>Download Image</button>
                                <button class="btn btn-outline-primary" id="regenerateImage"><i class="fas fa-redo me-2"></i>Regenerate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Video Generator -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header text-center py-3">
                        <i class="fas fa-video me-2"></i> AI Video Generator
                    </div>
                    <div class="card-body">
                        <form id="videoForm">
                            <div class="mb-3">
                                <label for="videoPrompt" class="form-label">Describe your video</label>
                                <textarea class="form-control" id="videoPrompt" rows="3" placeholder="E.g., A time-lapse of a flower blooming in a forest" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="videoDuration" class="form-label">Duration (seconds)</label>
                                <select class="form-select" id="videoDuration">
                                    <option value="5">5 seconds</option>
                                    <option value="10">10 seconds</option>
                                    <option value="15">15 seconds</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Generate Video</button>
                        </form>
                        
                        <div class="loading" id="videoLoading">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Generating your video... This may take up to a minute.</p>
                        </div>
                        
                        <div class="result-container" id="videoResult">
                            <h5 class="mb-3">Generated Video</h5>
                            <div class="text-center">
                                <video controls class="preview-video mb-3" id="generatedVideo">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" id="downloadVideo"><i class="fas fa-download me-2"></i>Download Video</button>
                                <button class="btn btn-outline-primary" id="regenerateVideo"><i class="fas fa-redo me-2"></i>Regenerate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Features Section -->
        <div class="row mt-5">
            <div class="col-12 text-center mb-5">
                <h2>Why Choose SocialAI Generator?</h2>
                <p class="lead">Powerful features to enhance your social media presence</p>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4>Fast Generation</h4>
                    <p>Create high-quality images and videos in seconds with our advanced AI technology.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <h4>Customizable</h4>
                    <p>Adjust styles, durations, and other parameters to get exactly what you need.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <h4>Easy Sharing</h4>
                    <p>Download and share your creations directly to all major social media platforms.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h5>SocialAI Generator</h5>
                    <p>Creating amazing social media content with AI</p>
                </div>
                <div class="col-md-6">
                    <h5>Connect With Us</h5>
                    <div class="d-flex justify-content-center">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <p>&copy; 2023 SocialAI Generator. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Image generation form handling
        document.getElementById('imageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const prompt = document.getElementById('imagePrompt').value;
            const style = document.getElementById('imageStyle').value;
            
            // Show loading, hide form
            document.getElementById('imageLoading').style.display = 'block';
            document.getElementById('imageForm').style.opacity = '0.5';
            
            // Simulate API call (in real implementation, this would call the PHP backend)
            setTimeout(() => {
                // Hide loading, show result
                document.getElementById('imageLoading').style.display = 'none';
                document.getElementById('imageForm').style.opacity = '1';
                document.getElementById('imageResult').style.display = 'block';
                
                // Set a placeholder image (in real implementation, this would be the generated image)
                document.getElementById('generatedImage').src = 'https://via.placeholder.com/512/6f42c1/ffffff?text=AI+Generated+Image';
            }, 2000);
        });
        
        // Video generation form handling
        document.getElementById('videoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const prompt = document.getElementById('videoPrompt').value;
            const duration = document.getElementById('videoDuration').value;
            
            // Show loading, hide form
            document.getElementById('videoLoading').style.display = 'block';
            document.getElementById('videoForm').style.opacity = '0.5';
            
            // Simulate API call (in real implementation, this would call the PHP backend)
            setTimeout(() => {
                // Hide loading, show result
                document.getElementById('videoLoading').style.display = 'none';
                document.getElementById('videoForm').style.opacity = '1';
                document.getElementById('videoResult').style.display = 'block';
                
                // Set a placeholder video (in real implementation, this would be the generated video)
                document.getElementById('generatedVideo').src = 'https://www.w3schools.com/html/mov_bbb.mp4';
            }, 3000);
        });
        
        // Regenerate buttons
        document.getElementById('regenerateImage').addEventListener('click', function() {
            document.getElementById('imageForm').dispatchEvent(new Event('submit'));
        });
        
        document.getElementById('regenerateVideo').addEventListener('click', function() {
            document.getElementById('videoForm').dispatchEvent(new Event('submit'));
        });
        
        // Download buttons (placeholder functionality)
        document.getElementById('downloadImage').addEventListener('click', function() {
            alert('In a real implementation, this would download the generated image.');
        });
        
        document.getElementById('downloadVideo').addEventListener('click', function() {
            alert('In a real implementation, this would download the generated video.');
        });
    </script>
</body>
</html>