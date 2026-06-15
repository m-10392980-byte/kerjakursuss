<?php
session_start();
include('header.php');
include('connection.php');

// Check if user is logged in
if (empty($_SESSION['jenisPengguna']) || $_SESSION['jenisPengguna'] != 'pengundi') {
    header('Location: login.php');
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: undi-calon.php');
    exit;
}

$noKP = $_SESSION['noKP'];
$positions_order = ['Pengerusi', 'Timbalan Pengerusi', 'Setiausaha', 'Bendahari'];

// Validate that all positions have votes
$votes = [];
$valid = true;

foreach ($positions_order as $position) {
    $fieldName = 'jawatan_' . str_replace(' ', '_', $position);
    
    if (!isset($_POST[$fieldName]) || empty($_POST[$fieldName])) {
        $valid = false;
        break;
    }
    
    $calon_id = (int)$_POST[$fieldName];
    $votes[$position] = $calon_id;
}

if (!$valid) {
    echo "<div style='text-align:center; margin: 50px auto; max-width: 600px;'>";
    echo "<h2 style='color: #ef4444;'>❌ Ralat</h2>";
    echo "<p style='font-size: 16px; color: #666;'>Sila pilih satu calon untuk setiap jawatan.</p>";
    echo "<a href='undi-calon.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #7c3aed; color: white; text-decoration: none; border-radius: 5px;'>Kembali</a>";
    echo "</div>";
    include('footer.php');
    exit;
}

// Check if user already voted
$check_vote = mysqli_query($condb, "SELECT * FROM undi WHERE noKPPengundi='" . mysqli_real_escape_string($condb, $noKP) . "'");

if (!$check_vote) {
    die("Database Error: " . mysqli_error($condb));
}

if (mysqli_num_rows($check_vote) > 0) {
    echo "<div style='text-align:center; margin: 50px auto; max-width: 600px;'>";
    echo "<h2 style='color: #ef4444;'>⚠️ Anda Sudah Mengundi</h2>";
    echo "<p style='font-size: 16px; color: #666;'>Maaf, anda hanya boleh mengundi sekali.</p>";
    echo "<a href='index.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #7c3aed; color: white; text-decoration: none; border-radius: 5px;'>Kembali ke Halaman Utama</a>";
    echo "</div>";
    include('footer.php');
    exit;
}

// Insert votes into database
$success = 0;
$fail = 0;

foreach ($votes as $position => $calon_id) {
    $insert_query = "INSERT INTO undi (noKPPengundi, idCalon, tarikhUndi) 
                     VALUES ('" . mysqli_real_escape_string($condb, $noKP) . "', $calon_id, NOW())";
    
    if (mysqli_query($condb, $insert_query)) {
        $success++;
    } else {
        $fail++;
    }
}

// Show success/failure message
if ($fail == 0) {
    echo "<div style='text-align:center; margin: 50px auto; max-width: 600px;'>";
    echo "<h2 style='color: #10b981;'>✓ Pengundian Berjaya!</h2>";
    echo "<p style='font-size: 16px; color: #666;'>Terima kasih atas penyertaan anda dalam pengundian AJK Kadet Polis.</p>";
    echo "<p style='font-size: 14px; color: #999;'>Anda telah mengundi untuk " . $success . " jawatan.</p>";
    echo "<a href='index.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #7c3aed; color: white; text-decoration: none; border-radius: 5px;'>Kembali ke Halaman Utama</a>";
    echo "</div>";
} else {
    echo "<div style='text-align:center; margin: 50px auto; max-width: 600px;'>";
    echo "<h2 style='color: #ef4444;'>⚠️ Ralat Semasa Menyimpan</h2>";
    echo "<p style='font-size: 16px; color: #666;'>Berjaya: $success | Gagal: $fail</p>";
    echo "<p style='font-size: 14px; color: #999;'>Sila hubungi pentadbir jika masalah berterusan.</p>";
    echo "<a href='undi-calon.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #7c3aed; color: white; text-decoration: none; border-radius: 5px;'>Kembali</a>";
    echo "</div>";
}

include('footer.php');
?>
