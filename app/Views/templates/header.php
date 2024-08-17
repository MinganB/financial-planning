<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link href="<?= base_url('bootstrap5/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/global.css?v=0.0.1') ?>" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="bg-light p-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">

            <!-- Desktop Header -->
            <div class="d-none d-lg-flex align-items-center w-100">
                <div class="me-auto">
                    <h3 class="m-0"><?= APP_NAME ?></h3>
                </div>
                <nav>
                    <ul class="nav">
                        <li class="nav-item"><a href="#" class="nav-link hover-link">Dashboard</a></li>
                        <li class="nav-item"><a href="#" class="nav-link hover-link">Settings</a></li>
                        <li class="nav-item"><a href="#" class="nav-link hover-link">Log out</a></li>
                    </ul>
                </nav>
            </div>

            <!-- Mobile Header -->
            <div class="d-flex d-lg-none align-items-center justify-content-between w-100">
                <button class="btn btn-link" id="backButton">
                    OO
                </button>
                <h5 class="m-0 text-center flex-grow-1">Page Title</h5>
                <button class="btn btn-link ms-auto" id="menuButton" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                    XX
                </button>
            </div>
        </div>
    </header>

    <!-- Hamburger menu for mobile -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Navigation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link">My budget</a></li>
                <li class="nav-item"><a href="#" class="nav-link">My net worth</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Financial planning</a></li>
                <li class="nav-item"><a href="#" class="nav-link">My profile</a></li>
                <li class="nav-item"><a href="#" class="nav-link">App settings</a></li>
            </ul>
        </div>
    </div>

    <main class="p-3">
        <!-- Main application body -->