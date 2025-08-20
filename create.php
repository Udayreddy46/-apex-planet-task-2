<?php
// Include database configuration
include 'config/database.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Insert post into the database
    $query = "INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id); // Set user_id as needed
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        echo "Post created successfully.";
    } else {
        echo "Error creating post.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create New Post</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
        <a href="read.php" class="btn btn-secondary mt-3">View Posts</a>
    </div>
</body>
</html>
