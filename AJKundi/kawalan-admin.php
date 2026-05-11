<head>
<link rel="stylesheet" href="css/style.css">
</head>

<?php
// HANYA MEMBENARKAN ADMIN SAHAJA YANG BOLEH AKSES FAIL

if(empty($_SESSION['jenisPengguna']) || $_SESSION['jenisPengguna'] != "admin"){
    die("<script>alert('sila login');
    window.location.href='logout.php';</script>");
}
?>