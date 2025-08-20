<?php
// Include database configuration
include 'config/database.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Pagination settings
$posts_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_condition = '';
$params = [];

if (!empty($search)) {
    $search_condition = " WHERE title LIKE :search OR content LIKE :search2";
    $params[':search'] = '%' . $search . '%';
    $params[':search2'] = '%' . $search . '%';
}

// Get total posts count for pagination
$count_query = "SELECT COUNT(*) as total FROM posts" . $search_condition;
$count_stmt = $conn->prepare($count_query);
if (!empty($search)) {
    $count_stmt->bindParam(':search', $params[':search']);
    $count_stmt->bindParam(':search2', $params[':search2']);
}
$count_stmt->execute();
$total_posts = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_posts / $posts_per_page);

// Fetch posts with pagination and search
$query = "SELECT * FROM posts" . $search_condition . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($query);
$stmt->bindParam(':limit', $posts_per_page, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

if (!empty($search)) {
    $stmt->bindParam(':search', $params[':search']);
    $stmt->bindParam(':search2', $params[':search2']);
}

$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts - Advanced Features</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .post-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .search-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .pagination .page-link {
            color: #0d6efd;
        }
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        .post-meta {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Blog App</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="create.php"><i class="fas fa-plus"></i> New Post</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="search-container">
            <form method="GET" action="read.php" class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search posts by title or content..." 
                               value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Blog Posts</h2>
            <span class="badge bg-secondary"><?php echo $total_posts; ?> posts</span>
        </div>

        <?php if (empty($posts)): ?>
            <div class="empty-state">
                <i class="fas fa-search fa-3x mb-3"></i>
                <h4>No posts found</h4>
                <p><?php echo !empty($search) ? 'Try adjusting your search terms.' : 'Be the first to create a post!'; ?></p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-12 mb-4">
                        <div class="card post-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title">
                                            <a href="read.php?id=<?php echo $post['id']; ?>" class="text-decoration-none">
                                                <?php echo htmlspecialchars($post['title']); ?>
                                            </a>
                                        </h5>
                                        <p class="card-text"><?php echo htmlspecialchars(substr($post['content'], 0, 200)) . '...'; ?></p>
                                        <div class="post-meta">
                                            <i class="fas fa-clock"></i> <?php echo date('M j, Y', strtotime($post['created_at'])); ?>
                                        </div>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <a href="read.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="update.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="delete.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Are you sure you want to delete this post?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="read.php?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="read.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="read.php?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <footer class="bg-light text-center py-4 mt-5">
        <p class="mb-0">&copy; 2024 Black Box Task 1 - Advanced Features</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
