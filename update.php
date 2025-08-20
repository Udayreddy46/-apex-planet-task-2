<?php
// Include database configuration
include 'config/database.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Initialize variables
$title = $content = '';
$errors = [];
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch existing post
if ($post_id > 0) {
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $post_id);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$post) {
        header('Location: read.php');
        exit();
    }
    
    $title = $post['title'];
    $content = $post['content'];
} else {
    header('Location: read.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    // Validation
    if (empty($title)) {
        $errors[] = 'Title is required.';
    } elseif (strlen($title) > 255) {
        $errors[] = 'Title must be less than 255 characters.';
    }
    
    if (empty($content)) {
        $errors[] = 'Content is required.';
    }
    
    // If no errors, update post
    if (empty($errors)) {
        $query = "UPDATE posts SET title = :title, content = :content, updated_at = NOW() WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':id', $post_id);
        
        if ($stmt->execute()) {
            header('Location: read.php?updated=1');
            exit();
        } else {
            $errors[] = 'Error updating post. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - Blog App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Blog App</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="read.php"><i class="fas fa-list"></i> All Posts</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h2 class="mb-4 text-center">Edit Post</h2>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?php echo htmlspecialchars($title); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="8" required><?php echo htmlspecialchars($content); ?></textarea>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="read.php" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center py-4 mt-5">
        <p class="mb-0">&copy; 2024 Black Box Task 1 - Advanced Features</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
