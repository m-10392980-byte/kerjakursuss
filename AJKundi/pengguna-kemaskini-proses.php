<head>
<link rel="stylesheet" href="css/style.css">
</head>

<?php
session_start();
include('kawalan-admin.php');
include('connection.php');

// Semak kewujudan data POST
if (!empty($_POST)) {
    $nama          = mysqli_real_escape_string($condb, $_POST['nama']);
    $noKP          = mysqli_real_escape_string($condb, $_POST['noKP']);
    $katalaluan    = mysqli_real_escape_string($condb, $_POST['katalaluan']);
    $noKP_lama     = mysqli_real_escape_string($condb, $_GET['noKP_lama']);
    $jenisPengguna = $_POST['jenisPengguna'];

// had atas had bawah nombor kad pengenalan: mestilah 12 digit
    if(strlen($noKP) < 12) {
        die("<script>
                alert('Ralat: Nombor Kad Pengenalan mesti 12 digit');
                window.history.back();
            </script>");
    }


    // Arahan SQL untuk kemaskini pengguna
    $arahan = "UPDATE pengguna SET
        nama = '$nama',
        noKP = '$noKP',
        katalaluan = '$katalaluan',
        jenisPengguna = '$jenisPengguna'
        WHERE noKP = '$noKP_lama'";

    if (mysqli_query($condb, $arahan)) {
        echo"<script>
                alert('Kemaskini Berjaya');
                window.location.href='pengguna-senarai.php';    
            </script>";
    } else {
        echo"<script>
                alert('Kemaskini Gagal');
                window.history.back();
            </script>";
    }

} else {
    die("<script>
            alert('Sila lengkapkan data');
            window.location.href='pengguna-senarai.php';
        </script>");
}
?>