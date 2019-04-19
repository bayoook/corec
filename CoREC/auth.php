<?php
session_start();
$status = 0;
if (isset($_SESSION["user"])) {
    $id = $_SESSION["user"]["id"];
    $status = $_SESSION["user"]["status"];
}
if ($status == 1) $link = "admin";
else if ($status == 2) $link = "mahasiswa";
else if ($status == 3) $link = "perusahaan";
