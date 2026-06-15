<head>
<link rel="stylesheet" href="css/style.css">
</head>

<?php
// HANYA MEMBENARKAN PENGGUNA BERDAFTAR SAHAJA YANG BOLEH AKSES FAIL

if(empty($_SESSION['jenisPengguna']) || $_SESSION['jenisPengguna'] != "pengundi"){
    die("<script>alert('sila login');
    window.location.href='logout.php';</script>");
}
?>