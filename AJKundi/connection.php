<?php
//  MENYAMBUNGKAN FAIL PHP KEPADA PANGKALAN DATA
$pangkalan_data = "VOTE4LEADER";
$condb = mysqli_connect('localhost', 'root', '', $pangkalan_data);

// Semak sambungan
if (!$condb) {
    die("Sambungan Gagal: " . mysqli_connect_error());
}

// Tetapkan character set
mysqli_set_charset($condb, "utf8mb4");
?>
