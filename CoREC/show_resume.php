<?php
require_once("auth.php");
require_once("conn.php");
if ($status != 1 && $status != 2 && $status != 3) {
    header("Location: login");
}

if ($status == 2) {
    $sql = "SELECT * FROM resume WHERE id_user=:id";
    $stmt = $db->prepare($sql);
    // bind parameter ke query
    $params1 = array(
        ":id" => $id,
    );
    $stmt->execute($params1);
    $user = $stmt->fetchAll();
} else {
    $sql = "SELECT * FROM resume";
    $sqln = "SELECT * FROM mahasiswa";
    $stmt = $db->prepare($sql);
    $stmtn = $db->prepare($sqln);
    $stmt->execute();
    $stmtn->execute();
    $user = $stmt->fetchAll();
    $mhs = $stmtn->fetchAll();
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
        <h1 style="font-family: Lato, sans-serif;font-size: 49px;margin-bottom: 30px;">Show Resume Mahasiswa</h1>

        <div class="container">
            <div class="table-responsive" style="background-color: #ffffff;color: rgb(0,0,0);">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Resume</th>
                            <?php
                            if ($status != 2) { ?>
                                <th>Pengarang</th>
                            <?php } ?><th>Tanggal Pembuatan</th>
                            <th>Tema Resume</th>
                            <th>Tahun Input</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($user as $row) {
                            $link = 'upload/' . $row['file'];
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['judul']; ?></td>
                                <?php
                                if ($status != 2) {
                                    foreach ($mhs as $rown) {
                                        if ($row["id_user"] == $rown["id"])
                                            $pengarang = $rown["nama"];
                                        else
                                            $pengarang = "Tidak Diketahui";
                                    }
                                    ?>
                                    <td><?php echo $pengarang; ?></td>
                                <?php } ?><td><?php echo $row['tanggal']; ?></td>
                                <td><?php echo $row['tema']; ?></td>
                                <td><?php echo $row['tahun']; ?></td>
                                <td><a href="<?php echo $link; ?>">Link</a></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </header>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="assets/js/freelancer.js"></script>
</body>

</html>