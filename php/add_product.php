<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $category = $_POST['category'];
    $barcode = trim($_POST['barcode']);
    $image_type = $_POST['image_type']; // Get image type (file or url)

    // Validate inputs
    if (empty($name) || empty($description) || $price <= 0 || $quantity < 0) {
        $error = "Please fill in all required fields correctly.";
    } else {
        try {
            // Check if barcode already exists
            if (!empty($barcode)) {
                $stmt = $pdo->prepare("SELECT id FROM inventory WHERE barcode = ?");
                $stmt->execute([$barcode]);
                if ($stmt->rowCount() > 0) {
                    throw new Exception("Barcode already exists");
                }
            }

            // Handle image based on type
            $image_url = null;
            if ($image_type === 'file') {
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_name = $_FILES['image']['name'];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');

                    if (!in_array($file_ext, $allowed_exts)) {
                        throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed.");
                    }

                    $upload_dir = '../uploads/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    $new_file_name = uniqid() . '.' . $file_ext;
                    $destination = $upload_dir . $new_file_name;

                    if (move_uploaded_file($file_tmp, $destination)) {
                        $image_url = 'uploads/' . $new_file_name;
                    } else {
                        throw new Exception("Error uploading file.");
                    }
                }
            } else {
                // Handle URL type
                $image_url = trim($_POST['image_url']);
                if (!empty($image_url) && !filter_var($image_url, FILTER_VALIDATE_URL)) {
                    throw new Exception("Please enter a valid image URL.");
                }
            }

            // Insert into database
            $stmt = $pdo->prepare("
                INSERT INTO inventory (
                    name, description, price, quantity, category, barcode, image_url, created_at
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP
                )
            ");

            $stmt->execute([
                $name,
                $description,
                $price,
                $quantity,
                $category,
                $barcode,
                $image_url
            ]);

            $_SESSION['success'] = "Product added successfully!";
            header("Location: manage_products.php");
            exit();

        } catch(Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Hot Wheels Collection</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/add_product.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .category-select {
            margin-bottom: 20px;
        }
        .category-option {
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
        }
        .category-Regular {
            background-color: #e8f5e9;
        }
        .category-Premium {
            background-color: #fff3e0;
        }
        .category-Limited {
            background-color: #ffebee;
        }
        .preview-image {
            max-width: 200px;
            margin-top: 10px;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.php">View Site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">Back to Products</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4">Add New Product</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (₱)</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Category</label>
                    <div class="category-select">
                        <div class="form-check category-option category-Regular">
                            <input class="form-check-input" type="radio" name="category" id="categoryRegular" value="Regular" checked>
                            <label class="form-check-label" for="categoryRegular">
                                Regular - Standard collection items
                            </label>
                        </div>
                        <div class="form-check category-option category-Premium">
                            <input class="form-check-input" type="radio" name="category" id="categoryPremium" value="Premium">
                            <label class="form-check-label" for="categoryPremium">
                                Premium - High-quality special editions
                            </label>
                        </div>
                        <div class="form-check category-option category-Limited">
                            <input class="form-check-input" type="radio" name="category" id="categoryLimited" value="Limited Edition">
                            <label class="form-check-label" for="categoryLimited">
                                Limited Edition - Rare and exclusive items
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="barcode" class="form-label">Barcode</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="barcode" name="barcode">
                        <button type="button" class="btn btn-outline-secondary" onclick="generateBarcode()">Generate</button>
                    </div>
                    <small class="text-muted">Leave empty to skip barcode or click generate for random barcode</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Image</label>
                    <div class="mb-3">
                        <select class="form-select" id="image_type" name="image_type">
                            <option value="file">Upload File</option>
                            <option value="url">Image URL</option>
                        </select>
                    </div>
                    <div id="file_upload_section">
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <div id="url_upload_section" style="display: none;">
                        <input type="url" class="form-control" id="image_url" name="image_url" placeholder="Enter image URL" onchange="previewImageURL(this)">
                    </div>
                    <div id="imagePreview" class="mt-3"></div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Add Product</button>
                    <a href="manage_products.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function generateBarcode() {
            // Generate random 13-digit number
            let barcode = '';
            for(let i = 0; i < 13; i++) {
                barcode += Math.floor(Math.random() * 10);
            }
            document.getElementById('barcode').value = barcode;
        }

        // Toggle between file upload and URL input
        document.getElementById('image_type').addEventListener('change', function() {
            const fileSection = document.getElementById('file_upload_section');
            const urlSection = document.getElementById('url_upload_section');
            const preview = document.getElementById('imagePreview');
            
            if (this.value === 'file') {
                fileSection.style.display = 'block';
                urlSection.style.display = 'none';
                document.getElementById('image_url').value = '';
            } else {
                fileSection.style.display = 'none';
                urlSection.style.display = 'block';
                document.getElementById('image').value = '';
            }
            preview.innerHTML = ''; // Clear preview
        });

        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('preview-image');
                    preview.appendChild(img);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewImageURL(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if (input.value) {
                const img = document.createElement('img');
                img.src = input.value;
                img.classList.add('preview-image');
                img.onerror = function() {
                    preview.innerHTML = '<div class="alert alert-danger">Invalid image URL</div>';
                };
                preview.appendChild(img);
            }
        }
    </script>
</body>
</html> 