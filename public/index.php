<?php
session_start();

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

    <!-- Homepage -->
    <div class="container">
        <h1>Recent Posts</h1>

        <!-- Posts -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><a href="php_backend/post"
                        class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
                        First Post: How
                        to structure a project?</a></h4>
                <p class="card-text">Posted by <a href="#">alex_dev</a> 2 hours ago</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><a href="#"
                        class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
                        CSS Grid vs.
                        Flexbox: Which to use?</a></h4>
                <p class="card-text">Posted by <a href="#">css_guru</a> 5 hours ago</p>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>