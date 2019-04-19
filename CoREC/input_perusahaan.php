<?php
require_once("auth.php");
require_once("conn.php");
if ($status != 3 && $status != 1) {
    header("Location: login");
}
if ($status == 1)
    $id = $_SESSION["id_edit"];
$sql = "SELECT * FROM perusahaan WHERE id=:id";
$stmt = $db->prepare($sql);
// bind parameter ke query
$params1 = array(
    ":id" => $id,
);
$stmt->execute($params1);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['input'])) {
    // filter data yang diinputkan
    $nama = filter_input(INPUT_POST, 'nama_perusahaan', FILTER_SANITIZE_STRING);
    $bidang = filter_input(INPUT_POST, 'bidang', FILTER_SANITIZE_STRING);
    $tahun = filter_input(INPUT_POST, 'tahun_terbentuk', FILTER_VALIDATE_INT);
    $pemilik = filter_input(INPUT_POST, 'pemilik', FILTER_SANITIZE_STRING);
    $link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_STRING);
    // menyiapkan query
    if ($user) {
        $sql = "UPDATE perusahaan SET nama=:nama,
                                      bidang=:bidang,
                                      tahun=:tahun,
                                      pemilik=:pemilik,
                                      link=:link
                                      WHERE id = :id";
    } else {
        $sql = "INSERT INTO perusahaan (id, nama, bidang, tahun, pemilik, link) 
        VALUES (:id, :nama, :bidang, :tahun, :pemilik, :link)";
    }
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":id" => $id,
        ":nama" => $nama,
        ":bidang" => $bidang,
        ":tahun" => $tahun,
        ":pemilik" => $pemilik,
        ":link" => $link
    );
    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if ($saved)
        header("Location: perusahaan");
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
        <h1 style="font-family: Lato, sans-serif;font-size: 49px;margin-bottom: 30px;">Data Perusahaan</h1>
        <form action="" method="POST">
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow" style="font-family: Lato, sans-serif;background-color: #ffffff;color: rgb(0,0,0);">Nama Perusahaan</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="nama_perusahaan" required type="text" name="nama_perusahaan" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;padding: 1px 5px;height: 30px; " value="" />
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Bergerak di Bidang</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="bidang" required type="text" name="bidang" class="border rounded-0 border-dark shadow-sm form-control" style="padding: 1px 5px;width: 100%;height: 30px;" />
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Tahun Terbentuk</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="tahun_terbentuk" required type="number" name="tahun_terbentuk" class="border rounded-0 border-dark shadow-sm form-control" style="padding: 1px 5px;width: 100%;height: 30px;" /></div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Nama Pemilik Saham</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="pemilik" required type="text" name="pemilik" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;padding: 1px 5px;height: 30px;" /></div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Link Perusahaan</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="link" type="text" required name="link" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;padding: 1px 5px;height: 30px;" /></div>
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
        document.getElementById("nama_perusahaan").value = "<?php echo $user['nama'] ?>";

        document.getElementById("bidang").value = "<?php echo $user['bidang'] ?>";
        document.getElementById("tahun_terbentuk").value = "<?php echo $user['tahun'] ?>";
        document.getElementById("pemilik").value = "<?php echo $user['pemilik'] ?>";
        document.getElementById("link").value = "<?php echo $user['link'] ?>";
    </script>
<?php
}
?>

</html>