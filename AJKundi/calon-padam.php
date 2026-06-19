<?php
session_start();
include('kawalan-admin.php');

if (!empty($_GET) && isset($_GET['idCalon'])) {
    include('connection.php');
    
    // Guna idCalon (nama parameter yang betul)
    $idCalon = mysqli_real_escape_string($condb, $_GET['idCalon']);
    
    // Debug: Papar error jika ada
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    try {
        // Guna idCalon (kolom database yang betul)
        $arahan = "DELETE FROM calon WHERE idCalon='$idCalon'";
        
        if (mysqli_query($condb, $arahan)) {
            if (mysqli_affected_rows($condb) > 0) {
                echo"<script>alert('Data Berjaya Dipadam');
                    window.location.href='calon-senarai.php';</script>";
            } else {
                echo"<script>alert('Tiada data yang dipadamkan - ID tidak ditemui');
                    window.location.href='calon-senarai.php';</script>";
            }
        } else {
            echo"<script>alert('Data Gagal Dipadam: " . mysqli_error($condb) . "');
                window.location.href='calon-senarai.php';</script>";
        }
    } catch (Exception $e) {
        echo"<script>alert('Ralat: " . $e->getMessage() . "');
            window.location.href='calon-senarai.php';</script>";
    }
} else {
    die("<script>alert('RALAT! akses secara terus atau parameter hilang');
        window.location.href='calon-senarai.php';</script>");
}
?>