<head>
<link rel="stylesheet" href="css/style.css">
</head>



<?php
include('header.php');
include('connection.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama       = mysqli_real_escape_string($condb, $_POST['nama']);
    $noKP      = mysqli_real_escape_string($condb, $_POST['noKP']);
    $katalaluan = mysqli_real_escape_string($condb, $_POST['katalaluan']);


    // SEMAK NO KP MESTI 12 DIGIT ATAU NOMBOR SAHAJA
    if(strlen($noKP) != 12){
        die("<script>
                alert('No Kad Pengenalan mesti tepat 12 digit atau nombor sahaja. Sila masukkan No Kad Pengenalan yang sah');
                window.history.back();
            </script>");
    }

    // SEMAK NOTEL DAH WUJUD ATAU BELUM
    $sql_semak = "select noKP from pengguna where noKP = '$noKP' ";
    $laksana_semak = mysqli_query($condb,$sql_semak);
    if(mysqli_num_rows($laksana_semak)==1){
        die("<script>
                alert('No Kad Pengenalan telah digunakan. Sila tukar No Kad Pengenalan yang lain');
                location.href='signup.php';
            </script>"); }

// SIMPAN DATA PENGGUNA BARU
    $query = "INSERT INTO pengguna
    (noKP, nama, katalaluan, jenisPengguna)
    VALUES ('$noKP', '$nama', '$katalaluan', 'pengundi')";
    if(mysqli_query($condb, $query)) {
        echo "<script>
                alert('Anda Telah Berjaya Mendaftar');
                location.href='login.php';
            </script>";
    } else {
        echo "<script>alert('Pendaftaran Gagal. Sila Cuba Lagi.');</script>";
        echo $sql_simpan.mysqli_error($condb);
    }
}
?>

<!-- BAHAGIAN BORANG SIGN UP -->
<form class="form" method='POST' action=''>
    <p class="title">Daftar Pengguna Baru</p>
    <p class="message">Sila Masukkan Maklumat Yang Diperlukan Di Bawah</p>

    <label class="field">
        <input class="finput" type="text" name="noKP" required placeholder=" ">
        <span>No Kad Pengenalan</span>
    </label>

    <label class="field">
        <input class="finput" type="text" name="nama" required placeholder=" ">
        <span>Nama</span>
    </label>
    <label class="field">
        <input class="finput" type="password" name="katalaluan" required placeholder=" ">
        <span>Katalaluan</span>
    </label>
    
    <button class="btn-primary" type="submit">Daftar</button>
    
</form>
<?php include('footer.php'); ?>