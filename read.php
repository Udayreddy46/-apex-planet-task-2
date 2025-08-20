<?php
// Include database configuration
include 'config/database.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Fetch posts from the database
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Blog Posts</h2>
        <a href="index.php" class="btn btn-primary">Back to Home</a>
        <div class="mt-3">
            <?php foreach ($posts as $post): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($post['content']); ?></p>
                        <p class="card-text"><small class="text-muted">Posted on <?php echo $post['created_at']; ?></small></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
