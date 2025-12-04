<?php
session_start();
require "../config/config.php";
// Validate ID
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Invalid post ID.");
}

$post_id = (int) $_GET['id'];

// Fetch post with author's details
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
                <a href="index.html" class="navbar-brand">
                    <!-- NOTE: This is the brand logo. -->
                    <img src="images/brand-logo.svg" alt="Brand Logo" width="40" height="40">
                    <span>DevForum</span>
                </a>

                <div class="collapse navbar-collapse" id="collapsible-bar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.html">Home</a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Posts</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">About</a></li>
                    </ul>

                </div>

                <?php
                if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
                    
                    echo "
                        <div class='d-flex flex-nowrap column-gap-2'>
                            <a href='new_post.php' class='nav-item btn btn-primary' role='button'>
                                <i class='bi bi-plus-lg'></i>
                            </a>
                            

                            <div class='dropdown'>
                                <button class='btn btn-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    <i class='bi bi-person-circle'></i>
                                </button>
                                <ul class='dropdown-menu dropdown-menu-end'>
                                    <li><a class='dropdown-item' href='#'>Action</a></li>
                                    <li><a class='dropdown-item' href='#'>Another action</a></li>
                                    <li><a class='dropdown-item' href='#'>Something else here</a></li>
                                </ul>
                            </div>


                        </div>
                    ";
                } else {
                    echo "
                    <div class='auth-btns d-flex flex-nowrap column-gap-2'>
                        <a href='login.html' class='nav-item btn btn-primary' role='button'>Login</a>
                        <a href='signup.html' class='nav-item btn btn-outline-primary' role='button'>Sign Up</a>
                    </div>
                    ";
                }
                ?>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-9">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h1 class="mb-3">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </h1>

                        <div class="text-muted mb-3">
                            <strong>By:</strong>
                            <?php
                            echo htmlspecialchars($post['first_name'] . " " . $post['last_name']);
                            ?>
                            |
                            <strong>Username:</strong>
                            <?php echo htmlspecialchars($post['username']); ?>
                            |
                            <strong>Published:</strong>
                            <?php echo $post['is_published'] ? "Yes" : "No"; ?>
                            |
                            <strong>Views:</strong>
                            <?php echo $post['views']; ?>
                        </div>

                        <div class="mb-4">
                            <p><?php echo nl2br(htmlspecialchars($post['body'])); ?></p>
                        </div>

                        <hr>

                        <div class="text-muted">
                            <strong>Upvotes:</strong> <?php echo $post['upvotes']; ?><br>
                            <strong>Downvotes:</strong> <?php echo $post['downvotes']; ?><br>
                            <strong>Created at:</strong> <?php echo $post['created_at']; ?><br>
                            <strong>Updated at:</strong> <?php echo $post['updated_at']; ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</body>

</html>