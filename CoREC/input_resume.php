<?php
require_once("auth.php");
require_once("conn.php");
if ($status != 2) {
    header("Location: login");
}

$sql = "SELECT * FROM resume WHERE id_user=:id";
$stmt = $db->prepare($sql);
// bind parameter ke query
$params1 = array(
    ":id" => $id,
);
$stmt->execute($params1);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['input'])) {
    try {
        $name_file = $_FILES['file']['name'];
        $type_file = $_FILES['file']['type'];
        $size_file = $_FILES['file']['size'];
        $temp_file = $_FILES['file']['tmp_name'];
        $error = $_FILES['file']['error'];
        print $error . "\n";
        $path = "upload/" . $name_file;
        if ($type_file == "application/pdf") {
            if (!file_exists($path)) {
                if ($size_file < 50000000) {
                    if (move_uploaded_file($temp_file, "upload/" . $name_file))
                        echo "success";
                    else
                        $errorMsg = "Your File to Large, Please Upload 5MB Size";
                } else
                    $errorMsg = "Your File to Large, Please Upload 5MB Size";
            } else
                $errorMsg = "File Already Exist ... Check Upload Folder";
        } else
            $errorMsg = "File Extension NOT Allowed, Please Upload .pdf";
        if (!isset($errorMsg)) {
            // filter data yang diinputkan
            $judul = filter_input(INPUT_POST, 'judul', FILTER_SANITIZE_STRING);
            $tanggal = filter_input(INPUT_POST, 'tanggal', FILTER_SANITIZE_STRING);
            $tema = filter_input(INPUT_POST, 'tema', FILTER_SANITIZE_STRING);
            $tahun = filter_input(INPUT_POST, 'tahun', FILTER_VALIDATE_INT);
            // menyiapkan query
            $sql = "INSERT INTO resume (id_user, judul, tanggal, tema, tahun, file) 
                    VALUES (:id, :judul, :tanggal, :tema, :tahun, :file)";
            $stmt = $db->prepare($sql);

            // bind parameter ke query
            $params = array(
                ":id" => $id,
                ":judul" => $judul,
                ":tanggal" => $tanggal,
                ":tema" => $tema,
                ":tahun" => $tahun,
                ":file" => $name_file
            );

            // eksekusi query untuk menyimpan ke database
            $saved = $stmt->execute($params);

            // jika query simpan berhasil, maka user sudah terdaftar
            // maka alihkan ke halaman login
            if ($saved)
                header("Location: mahasiswa");
        } else
            echo $errorMsg;
    } catch (PDOException $e) {
        echo $e->getMessage();
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
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="mahasiswa" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Home</a></li>
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="#about" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Company</a></li>
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="#contact" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">About</a></li>
                    <li role="presentation" class="nav-item mx-0 mx-lg-1"><a href="logout" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="masthead bg-primary text-white text-center" style="padding-top: 150px;background-color: transparent;">
        <h1 style="font-family: Lato, sans-serif;font-size: 49px;margin-bottom: 30px;">Input Resume Mahasiswa</h1>
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow" style="font-family: Lato, sans-serif;background-color: #ffffff;color: rgb(0,0,0);">Judul Resume</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="judul" required type="text" name="judul" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;padding: 1px 5px;height: 30px; " value="" />
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Tanggal Pembuatan</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="tanggal" required type="date" name="tanggal" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;height: 30px;" />
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Tema Resume</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="tema" type="text" required name="tema" class="border rounded-0 border-dark shadow-sm form-control" style="padding: 1px 5px;width: 100%;height: 30px;" />
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Tahun Input</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="tahun" type="number" required name="tahun" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;padding: 1px 5px;height: 30px;" /></div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col-lg-3 col-xl-3" style="padding: 15px;">
                        <h4 class="border rounded-0 border-dark shadow-sm" style="font-family: Lato, sans-serif;color: rgb(0,0,0);background-color: #ffffff;">Upload File</h4>
                    </div>
                    <div class="col" style="padding: 15px;">
                        <input id="file" type="file" required name="file" class="border rounded-0 border-dark shadow-sm form-control" style="width: 100%;padding: 1px 5px;height: 30px;" /></div>
                </div>
            </div>
            <div class="container">
                <div class="form-row">
                    <div class="col" style="padding: 15px;">
                        <button class="btn btn-primary border rounded-0 border-dark shadow-sm" type="submit" style="width: 100%;font-size: 24px;background-color: rgb(255,255,255);color: rgb(0,0,0);" name="input">Input</button></div>
                </div>
            </div>
        </form>
        <div class="container">
            <div class="form-row">
                <div class="col" style="padding: 15px;">
                    <a class="btn btn-light border rounded-0 border-dark shadow-sm" role="button" href="show_resume" style="width: 100%;font-size: 24px;background-color: rgb(255,255,255);color: rgb(0,0,0);">Lihat Resume</a>
                </div>
            </div>
        </div>
        </div>
    </header>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="assets/js/freelancer.js"></script>
</body>

</html>