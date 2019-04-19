<?php
require_once("conn.php");
require_once("auth.php");
if($status != 1 || $status !=2 || $status != 3){
    header("Location: $link");
}
if(isset($_POST['register'])){
    // filter data yang diinputkan
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

    // menyiapkan query
    $sql = "INSERT INTO user (nama, username, email, password, status) 
            VALUES (:name, :username, :email, :password, :status)";
    $stmt = $db->prepare($sql);


    // bind parameter ke query
    $params = array(
        ":name" => $name,
        ":username" => $username,
        ":password" => $password,
        ":email" => $email,
        ":status" => $status
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if($saved) {
        header("Location: /corec/?register=true");
    }
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>co-rec</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
</head>

<body style="background-color: rgb(24,188,156);">
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-secondary text-uppercase" id="mainNav">
        <div class="container"><a class="navbar-brand js-scroll-trigger" href="index">CO-REC</a><button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item mx-0 mx-lg-1" role="presentation"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="login">Login</a></li>
                    <li class="nav-item mx-0 mx-lg-1" role="presentation"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">About</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="masthead bg-primary text-white text-center" style="padding-top: 150px;background-color: transparent;">
        <h1 style="font-family: Lato, sans-serif;font-size: 49px;margin-bottom: 30px;">REGISTER</h1>
    <form action="" method="POST">   
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                    <h4 class="border rounded-0 border-dark shadow" style="font-family: Lato, sans-serif;background-color: #ffffff;color: rgb(0,0,0);">Nama</h4>
                </div>
                <div class="col" style="padding: 15px;">
                <input name="name" class="border rounded-0 border-dark shadow-sm" type="text" required style="width: 100%;padding: 1px 5px;"></div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Username</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                    <input  name="username" class="border rounded-0 border-dark shadow-sm" type="text" required style="width: 100%;padding: 1px 5px;"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Password</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                    <input name="password" class="border rounded-0 border-dark shadow-sm" type="password" required style="padding: 1px 5px;width: 100%;"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Email</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                    <input name="email" class="border rounded-0 border-dark shadow-sm" type="email" required style="width: 100%;padding: 1px 5px;"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Daftar Sebagai</h4>
                    </div>
                    <div class="col" style="padding: 15px; ">
                        <select name="status"class="border rounded-0 border-dark shadow-sm" required style="font-size: 18px;height: 30px;width: 100%;">
                            <option value="1">Admin</option>
                            <option value="2" selected>Mahasiswa</option>
                            <option value="3">Company</option>
                        </select>
                    </div>
                </div>
            </div> 
            <div class="container">
                <div class="row">
                    <div class="col" style="padding: 15px;">
                    <button class="btn btn-primary border rounded-0 border-dark shadow-sm" type="submit" style="width: 100%;font-size: 24px;background-color: rgb(255,255,255);color: rgb(0,0,0);" name="register" value="Daftar">Register</button></div>
                </div>
            </div>
        </form>
    </header>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="assets/js/freelancer.js"></script>
</body>

</html>