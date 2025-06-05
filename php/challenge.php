<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in or is a guest
$logged_in = isset($_SESSION['user_id']);
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$is_guest = isset($_SESSION['guest']);

// If not logged in and not a guest, redirect to login
if (!$logged_in && !$is_guest) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge Accepted - HOT4HAPART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/homepage.css">
    <link rel="stylesheet" href="../css/challenge.css">
</head>
<body class="challenge-page">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">HOT4HAPART</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="challenge-hero">
        <div class="container">
            <div class="challenge-content">
                <img src="../grrr.png" alt="HOT4HAPART Logo" class="challenge-logo">
                <h1 class="challenge-title display-4 fw-bold mb-4">CHALLENGE ACCEPTED™</h1>
                <h2 class="challenge-subtitle h2 mb-4">TRY. FAIL. REPEAT. GROW.</h2>
                <p class="lead mb-5">When you play with HOT4HAPART, every attempt teaches you to take on challenges, develop problem-solving skills, and cultivate a growth mindset.</p>
            </div>

            <div class="challenge-video">
                <video id="challengeVideo" class="challenge-video-player" poster="../child.png">
                    <source src="https://assets.contentstack.io/v3/assets/blt485dfa12bf05dba5/bltdbaed47dcf19e530/64d52fbc2a1c3cd270f72300/HWBPC23_HERO_60_16x9.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="play-button" id="playButton"></div>
            </div>

            <div class="growth-mindset mt-5 text-center">
                <h2 class="display-4 mb-4">What is a Growth Mindset</h2>
                <p class="lead">Studies show having a growth mindset is seeing every challenge as an opportunity to learn and grow. By overcoming obstacles, we build skills like resilience and determination and learn to say "Challenge Accepted."</p>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Video player functionality
        const video = document.getElementById('challengeVideo');
        const playButton = document.getElementById('playButton');
        
        playButton.addEventListener('click', function() {
            if (video.paused) {
                video.play();
                playButton.style.opacity = '0';
            } else {
                video.pause();
                playButton.style.opacity = '1';
            }
        });

        video.addEventListener('play', function() {
            playButton.style.opacity = '0';
        });

        video.addEventListener('pause', function() {
            playButton.style.opacity = '1';
        });

        video.addEventListener('ended', function() {
            playButton.style.opacity = '1';
        });
    </script>
</body>
</html> 