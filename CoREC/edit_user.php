<?php
require_once("conn.php");
require_once("auth.php");
if ($status != 1) {
    header("Location: login");
}
$id_edit = $_SESSION['id_edit'];
$sql = "SELECT * FROM user WHERE id=:id";
$stmt = $db->prepare($sql);
// bind parameter ke query
$params1 = array(
    ":id" => $id_edit,
);
$stmt->execute($params1);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['register'])) {
    // filter data yang diinputkan
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // enkripsi password
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $statusn = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

    // menyiapkan query
    $sql = "UPDATE user SET nama=:name, username=:username, email=:email, status=:status WHERE id=:id";
    $stmt = $db->prepare($sql);


    // bind parameter ke query
    $params = array(
        ":name" => $name,
        ":username" => $username,
        ":email" => $email,
        ":status" => $statusn,
        ":id" => $id_edit
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if ($saved) {
        header("Location: remove");
    }
}
if (isset($_POST['edit_more'])) {
    $statusn = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
    if ($statusn == 2) {
        header("Location: input_mahasiswa");
    }
    if ($statusn == 3) {
        header("Location: input_perusahaan");
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
        <div class="container"><a href="<?php echo $link ?>" class="navbar-brand js-scroll-trigger">CO-REC</a><button data-toggle="collapse" data-target="#navbarResponsive" class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="nav navbar-nav ml-auto">
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="<?php echo $link ?>" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Home</a></li>
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="#about" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Company</a></li>
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="#contact" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">About</a></li>
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="logout" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="masthead bg-primary text-white text-center" style="padding-top: 150px;background-color: transparent;">
        <h1 style="font-family: Lato, sans-serif;font-size: 49px;margin-bottom: 30px;">Edit User</h1>
        <form action="" method="POST">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow" style="font-family: Lato, sans-serif;background-color: #ffffff;color: rgb(0,0,0);">Nama</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="name" name="name" class="border rounded-0 border-dark shadow-sm" required type="text" style="width: 100%;padding: 1px 5px;"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Username</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="username" name="username" class="border rounded-0 border-dark shadow-sm" required type="text" style="width: 100%;padding: 1px 5px;"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Email</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="email" name="email" class="border rounded-0 border-dark shadow-sm" required type="email" style="width: 100%;padding: 1px 5px;"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Daftar Sebagai</h4>
                    </div>
                    <div class="col" style="padding: 15px; ">
                        <select id="status" name="status" class="border rounded-0 border-dark shadow-sm" required style="font-size: 18px;height: 30px;width: 100%;">
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
                        <button class="btn btn-primary border rounded-0 border-dark shadow-sm" type="submit" style="width: 100%;font-size: 24px;background-color: rgb(255,255,255);color: rgb(0,0,0);" name="register" value="edit">Edit</button></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col" style="padding: 15px;">
                        <button id="notadmin" class="btn btn-primary border rounded-0 border-dark shadow-sm" type="submit" style="width: 100%;font-size: 24px;background-color: rgb(255,255,255);color: rgb(0,0,0);" name="edit_more" value="edit_more">Edit More</button></div>
                </div>
            </div>
        </form>
    </header>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="assets/js/freelancer.js"></script>
</body>
<?php

if ($user) {
    $statusn = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
    ?>
    <script>
        if (<?php echo $user['status'] ?> == "1")
            document.getElementById("notadmin").hidden = true;
        document.getElementById("name").value = "<?php echo $user['nama'] ?>";
        document.getElementById("username").value = "<?php echo $user['username'] ?>";
        document.getElementById("email").value = "<?php echo $user['email'] ?>";
        document.getElementById("status").value = "<?php echo $user['status'] ?>";
    </script>
<?php
}
?>

</html>