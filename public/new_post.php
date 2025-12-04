<?php
session_start();

// Ensure logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
                            <a class="nav-link active" aria-current="page" href="index.html">Home</a>
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
            <div class="col-md-8">

                <h2 class="mb-4">Create a New Post</h2>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Post created successfully!</div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">Error saving post.</div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-body">

                        <form action="create_post.php" method="POST">

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="body" class="form-label">Body</label>
                                <textarea id="body" name="body" rows="8" class="form-control" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Publish</button>

                        </form>

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