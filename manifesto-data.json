<head>
<link rel="stylesheet" href="css/style.css">
</head>



<?php
session_start();
include('header.php');
include('connection.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // MENGAMBIL DATA DARIPADA BORANG DI BAWAH
    $noKP       = mysqli_real_escape_string($condb, $_POST['noKP']);
    $katalaluan = mysqli_real_escape_string($condb, $_POST['katalaluan']);

    // PROSES LOGIN PENGGUNA
    $query = "SELECT noKP, nama, jenisPengguna
    FROM pengguna
    WHERE noKP = '$noKP' AND katalaluan = '$katalaluan'";
    $result = mysqli_query($condb, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['noKP']          = $row['noKP'];
        $_SESSION['jenisPengguna'] = $row['jenisPengguna'];

        echo "<script> alert('Login Berjaya!'); </script>";
        header("Location: index.php");
        exit;
        
    } else {
        
        $err = "<p align='center' style='color:red;'>Login Gagal<br>
                Semak No Kad Pengenalan dan Katalaluan anda</p>";
    }
}
?>

<!-- BAHAGIAN BORANG LAIN -->
<form class="form" method='POST' action=''>
    <p class="title">Log Masuk Pengguna</p>
    <p class="message">Sila Masukkan Maklumat Yang Diperlukan Di Bawah</p>

    <label class="field">
        <input class="finput" type="text" name="noKP" required placeholder=" ">
        <span>No Kad Pengenalan</span>
    </label>

    <label class="field">
        <input class="finput" type="password" name="katalaluan" required placeholder=" ">
        <span>Katalaluan</span>
    </label>

    <button class="btn-primary" type="submit">Log Masuk</button>
            
    <?php if (!empty($err)) echo $err; ?>
</form>
<?php include('footer.php'); ?>