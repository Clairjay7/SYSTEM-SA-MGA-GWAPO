<!-- filepath: f:\xammp\htdocs\SYSTEM-SA-MGA-GWAPO\index.php -->
<?php
session_start();
require_once 'config/database.php';

// If user is already logged in, redirect to appropriate page
if (isset($_SESSION['user'])) {
    if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
        header("Location: php/admin_dashboard.php");
    } else {
        header("Location: php/homepage.php");
    }
    exit();
}

// If guest session exists, redirect to homepage
if (isset($_SESSION['guest'])) {
    header("Location: php/homepage.php");
    exit();
}

// Handle guest login if requested
if (isset($_GET['guest'])) {
    $_SESSION['guest'] = true;
    header("Location: php/homepage.php");
    exit();
}

// Clear any existing session data
if (!isset($_SESSION['user_id'])) {
    session_unset();
}

// Handle guest access
if (isset($_POST['guest_access'])) {
    try {
        // Generate a unique session ID
        $session_id = session_id();
        
        // Get client information
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        // Insert new guest session
        $stmt = $pdo->prepare("INSERT INTO guest_sessions (session_id, ip_address, user_agent, status) VALUES (?, ?, ?, 'active')");
        $stmt->execute([$session_id, $ip_address, $user_agent]);
        
        // Set session variables
        $_SESSION['guest'] = true;
        $_SESSION['guest_id'] = $session_id;
        
        header("Location: php/homepage.php");
        exit();
    } catch (PDOException $e) {
        // Log error and continue as guest anyway
        error_log("Guest session error: " . $e->getMessage());
        $_SESSION['guest'] = true;
        header("Location: php/homepage.php");
        exit();
    }
}

// Display success message if set
$success_message = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose User Type - Galorpot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <style>
        body {
            background-color: #0a1929;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .main-container {
            text-align: center;
            color: white;
            padding: 2rem;
        }

        .title {
            font-size: 2rem;
            margin-bottom: 3rem;
            color: white;
            font-weight: 300;
            letter-spacing: 1px;
        }

        .login-options {
            display: flex;
            justify-content: center;
            gap: 2rem;
        }

        .login-card {
            width: 200px;
            height: 200px;
            background-color: rgba(30, 136, 229, 0.05);
            border: 2px solid #1e88e5;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            backdrop-filter: blur(10px);
        }

        .login-card:hover {
            transform: translateY(-5px);
            border-color: #90caf9;
            box-shadow: 0 0 25px rgba(30, 136, 229, 0.4);
            background-color: rgba(30, 136, 229, 0.1);
        }

        .login-icon {
            font-size: 3rem;
            color: #1e88e5;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .login-card:hover .login-icon {
            color: #90caf9;
            transform: scale(1.1);
        }

        .login-text {
            font-size: 1.2rem;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 300;
        }

        /* Custom Modal Styling */
        .modal-content {
            background-color: #0a1929;
            border: 2px solid #1e88e5;
            border-radius: 16px;
            color: white;
            box-shadow: 0 0 30px rgba(30, 136, 229, 0.3);
        }

        .modal-header {
            border-bottom: 1px solid rgba(30, 136, 229, 0.2);
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 300;
            letter-spacing: 1px;
            font-size: 1.5rem;
        }

        .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .modal-body {
            padding: 2rem;
        }

        .form-label {
            color: #90caf9;
            font-weight: 300;
            margin-bottom: 0.5rem;
        }

        .form-control {
            background-color: rgba(30, 136, 229, 0.1);
            border: 1px solid #1e88e5;
            border-radius: 8px;
            color: white;
            padding: 0.8rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: rgba(30, 136, 229, 0.15);
            border-color: #90caf9;
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(30, 136, 229, 0.25);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .login-btn {
            background: linear-gradient(45deg, #1e88e5, #90caf9);
            border: none;
            border-radius: 8px;
            padding: 0.8rem;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 136, 229, 0.4);
            background: linear-gradient(45deg, #90caf9, #1e88e5);
        }

        @media (max-width: 576px) {
            .login-options {
                flex-direction: column;
                gap: 1rem;
            }

            .login-card {
                width: 180px;
                height: 180px;
            }
        }

        /* Error Alert Styling */
        .error-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1060;
        }

        .swal2-popup {
            background: #0a1929 !important;
            color: white !important;
            border: 2px solid #1e88e5 !important;
        }

        .swal2-title, .swal2-content {
            color: white !important;
        }

        .swal2-confirm {
            background: linear-gradient(45deg, #1e88e5, #90caf9) !important;
            border: none !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <div class="main-container">
        <h1 class="title">Choose user type</h1>
        
        <div class="login-options">
            <!-- Guest Login Card -->
            <form method="POST" style="margin: 0;">
                <button type="submit" name="guest_access" class="login-card" style="background: none; width: 100%; height: 100%;">
                    <i class="bi bi-person login-icon"></i>
                    <span class="login-text">Guest</span>
                </button>
            </form>

            <!-- Employee Login Card -->
            <a href="#" class="login-card" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="bi bi-person-badge login-icon"></i>
                <span class="login-text">Employee</span>
            </a>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Employee Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" method="POST" action="php/login_action.php" onsubmit="return validateForm()">
                        <div class="mb-4">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required placeholder="Enter your username">
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary login-btn">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="js/login.js"></script>
    <script>
        // Check for PHP session error on page load
        <?php if (isset($_SESSION['error'])): ?>
            checkSessionError('<?php echo $_SESSION['error']; ?>');
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>
</body>
</html>