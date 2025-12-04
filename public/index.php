<?php
session_start();
require "../config/config.php";
// Get posts from last 7 days
$query = "
    SELECT 
        p.post_id,
        p.title,
        p.body,
        p.views,
        p.is_published,
        p.created_at,
        p.updated_at,
        p.upvotes,
        p.downvotes,
        u.username,
        u.first_name,
        u.last_name
    FROM posts p
    INNER JOIN users u ON p.user_id = u.user_id
    WHERE p.created_at >= (NOW() - INTERVAL 7 DAY)
    ORDER BY p.created_at DESC
";

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dev Community Forum</title>

    <!-- Google Font (Inter) to match your design -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>

    <?php include "nav.php"; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Recent Posts (Last 7 Days)</h2>

        <?php if ($result->num_rows === 0): ?>
            <div class="alert alert-warning">No posts in the last week.</div>
        <?php else: ?>

            <?php while ($post = $result->fetch_assoc()): ?>
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">

                        <h4 class="card-title">
                            <a href="view_post.php?id=<?php echo $post['post_id']; ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h4>

                        <div class="text-muted mb-2">
                            <strong>By:</strong>
                            <?php echo htmlspecialchars($post['first_name'] . " " . $post['last_name']); ?>
                            |
                            <strong>Published:</strong>
                            <?php echo $post['created_at']; ?>
                            |
                            <strong>Views:</strong>
                            <?php echo $post['views']; ?>
                        </div>

                        <p class="card-text">
                            <?php
                            $preview = substr($post['body'], 0, 200);
                            echo nl2br(htmlspecialchars($preview));
                            if (strlen($post['body']) > 200)
                                echo "...";
                            ?>
                        </p>

                        <a href="show_post.php?id=<?php echo $post['post_id']; ?>" class="btn btn-primary">
                            Read More
                        </a>

                    </div>
                </div>
            <?php endwhile; ?>

        <?php endif; ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="js/change_active_navbar_link.js"></script>
</body>

</html>