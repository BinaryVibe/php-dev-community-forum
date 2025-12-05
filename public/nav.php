<header class="main-header">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#collapsible-bar">
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
                        <a class="nav-link" id="home" href="index.php">Home</a>
                    </li>
                    <li class="nav-item"><a href="posts.php" id="posts" class="nav-link">Posts</a></li>
                    <li class="nav-item"><a href="#" id="about" class="nav-link">About</a></li>
                </ul>

            </div>

            <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true): ?>


                <div class='d-flex flex-nowrap column-gap-2'>
                    <a href='new_post.php' data-bs-toggle="tooltip" data-bs-title="Create Post" class='nav-item btn btn-primary' role='button'>
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
                            <li><a class='dropdown-item link-danger' href='logout.php'>Log Out</a></li>
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

<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>