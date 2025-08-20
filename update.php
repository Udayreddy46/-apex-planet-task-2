<?php
// Include database configuration
include 'config/database.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update post in the database
    $query = "UPDATE posts SET title = :title, content = :content WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        echo "Post updated successfully.";
    } else {
        echo "Error updating post.";
    }
}

// Fetch the post to be updated
$post_id = $_GET['id'];
$query = "SELECT * FROM posts WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $post_id);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Update Post</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
        <a href="read.php" class="btn btn-secondary mt-3">View Posts</a>
    </div>
</body>
</html>
