<?php
require_once("auth.php");
require_once("conn.php");
if ($status != 2 && $status != 1) {
    header("Location: login");
}
if ($status == 1)
    $id = $_SESSION["id_edit"];
$sql = "SELECT * FROM mahasiswa WHERE id=:id";
$stmt = $db->prepare($sql);
// bind parameter ke query
$params1 = array(
    ":id" => $id,
);
$stmt->execute($params1);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['input'])) {
    // filter data yang diinputkan
    $name = filter_input(INPUT_POST, 'nama_lengkap', FILTER_SANITIZE_STRING);
    $tempat_lahir = filter_input(INPUT_POST, 'tempat_lahir', FILTER_SANITIZE_STRING);
    $tanggal_lahir = filter_input(INPUT_POST, 'tanggal_lahir', FILTER_SANITIZE_STRING);
    $jurusan = filter_input(INPUT_POST, 'jurusan', FILTER_SANITIZE_STRING);
    $angkatan = filter_input(INPUT_POST, 'angkatan', FILTER_VALIDATE_INT);
    $nim = filter_input(INPUT_POST, 'nim', FILTER_VALIDATE_INT);
    $kelas = filter_input(INPUT_POST, 'kelas', FILTER_SANITIZE_STRING);
    $ttl = $tempat_lahir . " " . $tanggal_lahir;
    // menyiapkan query
    if ($user) {
        $sql = "UPDATE mahasiswa SET nama=:name,
                                     ttl=:ttl,
                                     jurusan=:jurusan,
                                     angkatan=:angkatan,
                                     nim=:nim,
                                     kelas=:kelas
                                     WHERE id = :id";
        $stmt = $db->prepare($sql);
        // bind parameter ke query
        $params = array(
            ":id" => $id,
            ":name" => $name,
            ":ttl" => $ttl,
            ":jurusan" => $jurusan,
            ":angkatan" => $angkatan,
            ":nim" => $nim,
            ":kelas" => $kelas,
        );
    } else {
        $sql = "INSERT INTO mahasiswa (id, nama, ttl, jurusan, angkatan, nim, kelas) 
        VALUES (:id, :name, :ttl, :jurusan, :angkatan, :nim, :kelas)";
        $stmt = $db->prepare($sql);

        // bind parameter ke query
        $params = array(
            ":id" => $id,
            ":name" => $name,
            ":ttl" => $ttl,
            ":jurusan" => $jurusan,
            ":angkatan" => $angkatan,
            ":nim" => $nim,
            ":kelas" => $kelas,
        );
    }

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if ($saved)
        header("Location: mahasiswa");
}
?>

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
        <h1 style="font-family: Lato, sans-serif;font-size: 49px;margin-bottom: 30px;">Data Mahasiswa</h1>
        <form action="" method="POST">
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Nama Lengkap</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="nama_lengkap" type="text" required name="nama_lengkap" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;padding: 1px 5px;height: 30px; " value="" />
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">TTL</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <input id="tempat_lahir" required type="text" name="tempat_lahir" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;padding: 1px 5px;height: 30px;" />
                            </div>
                            <div class="col">
                                <input id="tanggal_lahir" required type="date" name="tanggal_lahir" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;height: 30px;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Jurusan
                        </h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="jurusan" type="text" required name="jurusan" class="border rounded-0 border-dark shadow-sm form-control" style="padding: 1px 5px;width: 100%;height: 30px;" />
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Angkatan
                        </h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="angkatan" type="number" required name="angkatan" class="border rounded-0 border-dark shadow-sm form-control" style="padding: 1px 5px;width: 100%;height: 30px;" /></div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">NIM</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="nim" type="number" required name="nim" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;padding: 1px 5px;height: 30px;" /></div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Kelas
                        </h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="kelas" type="text" required name="kelas" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;padding: 1px 5px;height: 30px;" /></div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col" style="padding: 15px;">
                        <button class="btn btn-primary border rounded-0 border-dark shadow-sm" type="submit" style="width: 100%;font-size: 24px;background-color: rgb(255,255,255);color: rgb(0,0,0);" name="input">Input</button></div>
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

// jika user terdaftar
if ($user) {
    // verifikasi password
    ?>
    <script>
        document.getElementById("nama_lengkap").value = "<?php echo $user['nama'] ?>";
        var ttl = "<?php echo $user['ttl'] ?>";
        var tempat = ttl.substr(0, ttl.indexOf(' '));
        var tanggal = ttl.substr(ttl.indexOf(' ') + 1);
        document.getElementById("tempat_lahir").value = tempat;
        document.getElementById("tanggal_lahir").value = tanggal;
        document.getElementById("jurusan").value = "<?php echo $user['jurusan'] ?>";
        document.getElementById("angkatan").value = "<?php echo $user['angkatan'] ?>";
        document.getElementById("nim").value = "<?php echo $user['nim'] ?>";
        document.getElementById("kelas").value = "<?php echo $user['kelas'] ?>";
    </script>
<?php
}
?>

</html>