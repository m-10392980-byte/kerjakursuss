<head>
<link rel="stylesheet" href="css/style.css">
</head>

<?php
include('header.php');
include('connection.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama       = mysqli_real_escape_string($condb, $_POST['nama']);
    $noKP       = mysqli_real_escape_string($condb, $_POST['noKP']);
    $katalaluan = mysqli_real_escape_string($condb, $_POST['katalaluan']);

    // SEMAK NO KP - LEBIH ATAU KURANG 12 DIGIT
    if(strlen($noKP) > 12){
        die("<script>
                alert('Had nombor adalah 12. Sila masukkan No Kad Pengenalan yang tepat 12 digit.');
                window.history.back();
            </script>");
    } elseif(strlen($noKP) < 12){
        die("<script>
                alert('No anda kurang daripada 12. Sila masukkan No Kad Pengenalan yang lengkap 12 digit.');
                window.history.back();
            </script>");
    }

    // SEMAK SAMA ADA NOMBOR SAHAJA
    if(!ctype_digit($noKP)){
        die("<script>
                alert('No Kad Pengenalan mestilah nombor sahaja. Sila semak semula.');
                window.history.back();
            </script>");
    }

    // SEMAK NO KP DAH WUJUD ATAU BELUM
    $sql_semak = "SELECT noKP FROM pengguna WHERE noKP = '$noKP'";
    $laksana_semak = mysqli_query($condb, $sql_semak);
    if(mysqli_num_rows($laksana_semak) == 1){
        die("<script>
                alert('No Kad Pengenalan telah digunakan. Sila tukar No Kad Pengenalan yang lain.');
                location.href='signup.php';
            </script>");
    }

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
        echo mysqli_error($condb);
    }
}
?>

<!-- BAHAGIAN BORANG SIGN UP -->
<form class="form" method='POST' action='' onsubmit="return validateForm()">
    <p class="title">Daftar Pengguna Baru</p>
    <p class="message">Sila Masukkan Maklumat Yang Diperlukan Di Bawah</p>

    <label class="field">
        <input 
            class="finput" 
            type="text" 
            name="noKP" 
            id="noKP"
            required 
            placeholder=" "
            maxlength="12"
            oninput="semakNoKP(this)"
        >
        <span>No Kad Pengenalan</span>
        <!-- Mesej error real-time -->
        <small id="noKP-msg" style="color:red; font-size:12px; display:none;"></small>
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

<script>
    // Semak No KP masa pengguna menaip (real-time)
    function semakNoKP(input) {
        var nilai = input.value.replace(/\D/g, ''); // buang bukan nombor
        input.value = nilai; // pastikan nombor sahaja boleh masuk

        var msg = document.getElementById('noKP-msg');

        if (nilai.length > 12) {
            msg.textContent = 'Had nombor adalah 12.';
            msg.style.display = 'block';
        } else if (nilai.length < 12 && nilai.length > 0) {
            msg.textContent = 'No anda kurang daripada 12. (' + nilai.length + '/12)';
            msg.style.display = 'block';
        } else if (nilai.length === 12) {
            msg.textContent = 'No Kad Pengenalan sah!';
            msg.style.color = 'green';
            msg.style.display = 'block';
        } else {
            msg.style.display = 'none';
        }

        if (nilai.length < 12) {
            msg.style.color = 'red';
        }
    }

    // Validate sebelum submit
    function validateForm() {
        var noKP = document.getElementById('noKP').value;

        if (noKP.length > 12) {
            alert('Had nombor adalah 12. Sila masukkan No Kad Pengenalan yang tepat 12 digit.');
            return false;
        } else if (noKP.length < 12) {
            alert('No anda kurang daripada 12. Sila masukkan No Kad Pengenalan yang lengkap 12 digit.');
            return false;
        }

        return true;
    }
</script>

<?php include('footer.php'); ?>
