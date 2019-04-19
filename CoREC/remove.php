<?php
require_once("auth.php");
require_once("conn.php");
if ($status != 1) {
    header("Location: login");
}
$sql = "SELECT * FROM user";
$stmt = $db->prepare($sql);
$stmt->execute();
$user = $stmt->fetchAll();
if (isset($_POST['delete'])) {

    $id_user = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    if ($status == 1) {
        exit();
    }
    $sql = "DELETE FROM user WHERE id=:id";
    $stmt = $db->prepare($sql);
    // bind parameter ke query
    $params = array(
        ":id" => $id_user
    );
    $saved = $stmt->execute($params);

    if ($status == 2) {
        $sqln = "DELETE FROM mahasiswa WHERE id=:id";
        $sqlo = "DELETE FROM 'resume' WHERE id_user=:id";
        $stmto = $db->prepare($sqlo);
        $savedo = $stmto->execute($params);
    }
    if ($status == 3) {
        $sqln = "DELETE FROM perusahaan WHERE id=:id";
    }
    $stmtn = $db->prepare($sqln);
    $savedn = $stmtn->execute($params);
    if ($saved && $savedn) {
        if ($status == 2 && $savedo)
            header("Location: remove");
        else if ($status != 2)
            header("Location: remove");
    }
}
if (isset($_POST['edit'])) {
    $id_user = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $_SESSION["id_edit"] = $id_user;
    header("Location: edit_user");
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
        <h1 style="font-family: Lato, sans-serif;font-size: 49px;margin-bottom: 30px;">Data User</h1>

        <div class="container">
            <div class="table-responsive" style="background-color: #ffffff;color: rgb(0,0,0);">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($user as $row) {
                            if ($row['status'] == 1)
                                $s = "Admin";
                            if ($row['status'] == 2)
                                $s = "Mahasiswa";
                            if ($row['status'] == 3)
                                $s = "Company";
                            ?>
                            <tr>
                                <form action="" method="POST">
                                    <input type="text" name="id" value="<?php echo $row['id']; ?>" hidden />
                                    <input type="text" name="status" value="<?php echo $row['status']; ?>" hidden />
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['nama']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $s; ?></td>
                                    <td><button type="submit" name="edit" value="edit" style="width: 40%;">Edit</button>
                                        <button id='delete_<?php echo $i; ?>' type="submit" name="delete" value="delete" style="width: 40%;">Delete</button></td>
                                </form>
                            </tr>
                            <?php
                            if ($row['status'] == 1) {
                                ?>
                                <script>
                                    document.getElementById('delete_<?php echo $i; ?>').disabled = true;
                                </script>
                            <?php
                        }
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