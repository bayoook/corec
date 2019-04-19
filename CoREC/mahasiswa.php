<?php
require_once("auth.php");
if ($status != 2) {
    header("Location: login");
}
?>


<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - CO-REC</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
</head>

<body style="background-color: rgb(24,188,156);">
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-secondary text-uppercase" id="mainNav">
        <div class="container"><a href="<?php echo $link ?>" class="navbar-brand js-scroll-trigger">CO-REC</a><button data-toggle="collapse" data-target="#navbarResponsive" class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="nav navbar-nav ml-auto">
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="mahasiswa" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Home</a></li>
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="#about" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Company</a></li>
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="#contact" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">About</a></li>
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="logout" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="masthead bg-primary text-white text-center">
        <h1 style="padding-bottom: 28px;">Selamat Datang Mahasiswa</h1>
        <div class="container"><img src="assets/img/profile.png" class="img-fluid d-block mx-auto mb-5" />
            <h1>CO-REC</h1>
            <hr class="star-light" />
            <h2 class="font-weight-light mb-0">Company Recruitments</h2>
        </div>
        <div role="group" class="btn-group"></div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <a class="btn btn-light border rounded-0 border-dark shadow-sm" role="button" href="input_mahasiswa" style="width: 100%;">Input Data </a>
                </div>
                <div class="col" style="width: 100%;">
                    <a class="btn btn-light border rounded-0 border-dark shadow-sm" role="button" href="input_resume" style="width: 100%;">Input Resume</a>
                </div>
                <div class="col">
                    <a class="btn btn-light border rounded-0 border-dark shadow-sm" role="button" href="show_company" style="width: 100%;">Show Company</a>
                </div>
            </div>
        </div>
    </header>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="assets/js/freelancer.js"></script>
</body>