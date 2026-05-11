<head>
<link rel="stylesheet" href="css/style.css">
</head>

<?php
session_start();
include('kawalan-admin.php');

if (!empty($_GET)) {
    include('connection.php');
    $noCalon = mysqli_real_escape_string($condb, $_GET['noCalon']);

    // proses padam data calon
    $arahan = "DELETE FROM calon WHERE noCalon='$noCalon'";
    if (mysqli_query($condb, $arahan)) {
        echo"<script>alert('Data Berjaya Dipadam');
            window.location.href='calon-senarai.php';</script>";
    } else {

        echo"<script>alert('Data Gagal Dipadam');
            window.location.href='calon-senarai.php';</script>";
    }
} else {
    die("<script>alert('RALAT! akses secara terus');
        window.location.href='calon-senarai.php';</script>");
}
?>