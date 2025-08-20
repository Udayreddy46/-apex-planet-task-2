<?php
// Include database configuration
include 'config/database.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Handle deletion
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete post from the database
    $query = "DELETE FROM posts WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Post deleted successfully.";
    } else {
        echo "Error deleting post.";
    }
}

// Redirect to read.php after deletion
header("Location: read.php");
exit();
?>
