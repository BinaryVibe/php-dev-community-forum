<?php
session_start();
require "../config/config.php";

$query = "
    SELECT 
        p.post_id, 
        p.title, 
        p.body, 
        p.created_at, 
        p.views, 
        p.upvotes, 
        p.downvotes,
        u.username, 
        u.first_name, 
        u.last_name 
    FROM posts p
    JOIN users u ON p.user_id = u.user_id
    WHERE p.is_published = 1
    ORDER BY p.created_at DESC
";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts - DevForum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        xintegrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

    <?php include "nav.php"; ?>

    <div class="container">


        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($post = $result->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm hover-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="show_post.php?id=<?php echo $post['post_id']; ?>"
                                        class="text-decoration-none text-dark stretched-link">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h5>
                                <div class="card-subtitle mb-3 text-muted small">
                                    By <span class="fw-bold"><?php echo htmlspecialchars($post['username']); ?></span>
                                    &bull; <?php echo date("M d, Y", strtotime($post['created_at'])); ?>
                                </div>
                                <p class="card-text text-secondary">
                                    <?php
                                    $body = htmlspecialchars($post['body']);
                                    echo strlen($body) > 100 ? substr($body, 0, 100) . "..." : $body;
                                    ?>
                                </p>
                            </div>
                            <div class="card-footer bg-white border-top-0 d-flex justify-content-between text-muted small pb-3">
                                <div>
                                    <i class="bi bi-eye"></i> <?php echo $post['views']; ?>
                                </div>
                                <div>
                                    <span class="text-success me-2"><i class="bi bi-arrow-up"></i>
                                        <?php echo $post['upvotes']; ?></span>
                                    <span class="text-danger"><i class="bi bi-arrow-down"></i>
                                        <?php echo $post['downvotes']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No posts found. Be the first to <a href="new_post.php">create one!</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        xintegrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="js/change_active_navbar_link.js"></script>

</body>

</html>