<?php
session_start();
require "../config/config.php";

$post_id = (int) $_GET['id'];
$user_id = $_SESSION['user_id'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must be logged in to vote.');</script>";
    } else {
        $action = $_POST['action'];
        if ($action === 'upvote') {
            $conn->query("UPDATE posts SET upvotes = upvotes + 1 WHERE post_id = $post_id");
        } elseif ($action === 'downvote') {
            $conn->query("UPDATE posts SET downvotes = downvotes + 1 WHERE post_id = $post_id");
        }
        header("Location: show_post.php?id=" . $post_id);
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['btn_comment'])) {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must be logged in to comment.');</script>";
    } else {
        $comment_body = trim($_POST['comment_body']);
        if (!empty($comment_body)) {
            $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, body) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $post_id, $user_id, $comment_body);
            $stmt->execute();
            $stmt->close();
            header("Location: show_post.php?id=" . $post_id . "#comments-section");
            exit;
        }
    }
}

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
    WHERE p.post_id = ?
";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Post not found.");
}

$post = $result->fetch_assoc();
$stmt->close();

$conn->query("UPDATE posts SET views = views + 1 WHERE post_id = $post_id");

$comments_query = "
    SELECT c.body, c.created_at, u.username 
    FROM comments c
    JOIN users u ON c.user_id = u.user_id
    WHERE c.post_id = $post_id
    ORDER BY c.created_at DESC
";
$comments_result = $conn->query($comments_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <header class="main-header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                    data-bs-target="#collapsible-bar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a href="index.php" class="navbar-brand">
                    <img src="images/brand-logo.svg" alt="Brand Logo" width="40" height="40">
                    <span>DevForum</span>
                </a>

                <div class="collapse navbar-collapse" id="collapsible-bar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Posts</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">About</a></li>
                    </ul>
                </div>

                <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true): ?>


                    <div class='d-flex flex-nowrap column-gap-2'>
                        <a href='new_post.php' class='nav-item btn btn-primary' role='button'>
                            <i class='bi bi-plus-lg'></i>
                        </a>


                        <div class='dropdown'>
                            <button class='btn btn-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown'
                                aria-expanded='false'>
                                <i class='bi bi-person-circle'></i>
                            </button>
                            <ul class='dropdown-menu dropdown-menu-end'>
                                <li><a class='dropdown-item' href='#'>Action</a></li>
                                <li><a class='dropdown-item' href='#'>Another action</a></li>
                                <li><a class='dropdown-item' href='#'>Something else here</a></li>
                            </ul>
                        </div>


                    </div>

                <?php else: ?>

                    <div class='auth-btns d-flex flex-nowrap column-gap-2'>
                        <a href='login.html' class='nav-item btn btn-primary' role='button'>Login</a>
                        <a href='signup.html' class='nav-item btn btn-outline-primary' role='button'>Sign Up</a>
                    </div>


                <?php endif; ?>
            </div>
        </nav>
    </header>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-9">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h1 class="mb-3">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </h1>

                        <div class="text-muted mb-3">
                            <strong>By:</strong>
                            <?php echo htmlspecialchars($post['first_name'] . " " . $post['last_name']); ?>
                            |
                            <strong>Username:</strong>
                            <?php echo htmlspecialchars($post['username']); ?>
                            |
                            <strong>Views:</strong>
                            <?php echo $post['views']; ?>
                        </div>

                        <div class="mb-4">
                            <p><?php echo nl2br(htmlspecialchars($post['body'])); ?></p>
                        </div>

                        <hr>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="action" value="upvote">
                                <button type="submit" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-arrow-up-circle-fill"></i> Upvote (<?php echo $post['upvotes']; ?>)
                                </button>
                            </form>

                            <form method="POST" class="d-inline">
                                <input type="hidden" name="action" value="downvote">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-arrow-down-circle-fill"></i> Downvote
                                    (<?php echo $post['downvotes']; ?>)
                                </button>
                            </form>
                        </div>

                        <div class="text-muted small">
                            Created at: <?php echo $post['created_at']; ?><br>
                            Updated at: <?php echo $post['updated_at']; ?>
                        </div>

                    </div>
                </div>
                <div class="mt-5" id="comments-section">
                    <h3>Comments</h3>

                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Add a comment</label>
                                        <textarea name="comment_body" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" name="btn_comment" class="btn btn-primary btn-sm">Post
                                        Comment</button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            You must be <a href="login.html">logged in</a> to post a comment.
                        </div>
                    <?php endif; ?>

                    <?php if ($comments_result->num_rows > 0): ?>
                        <?php while ($comment = $comments_result->fetch_assoc()): ?>
                            <div class="card mb-2">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong
                                            class="text-primary">@<?php echo htmlspecialchars($comment['username']); ?></strong>
                                        <small class="text-muted"><?php echo $comment['created_at']; ?></small>
                                    </div>
                                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($comment['body'])); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-muted">No comments yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>