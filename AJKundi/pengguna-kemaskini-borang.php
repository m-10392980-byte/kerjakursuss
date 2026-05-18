<head>
<link rel="stylesheet" href="css/style.css">
</head>

<?php
session_start();
include('header.php');
include('kawalan-admin.php');
include('connection.php');

// Semak kewujudan data GET
if(empty($_GET)) {
    die("<script>window.location.href='pengguna-senarai.php';</script>");
}
// Dapatkan maklumat pengguna berdasarkan Nombor Kad Pengenalan
$noKP = mysqli_real_escape_string($condb, $_GET['noKP']);
$sql = "SELECT * FROM pengguna WHERE noKP = '$noKP'";
$laksana = mysqli_query($condb, $sql);
$m = mysqli_fetch_array($laksana);
?>
<h3>Kemaskini Maklumat Pengguna</h3>
<!-- Borang dalam bentuk jadual -->
<form action='pengguna-kemaskini-proses.php?noKP_lama=<?= $noKP ?>' method='POST'>
    <table>
        <tr>
            <td><label>Nama:</label></td>
            <td><input type='text' name='nama' value='<?= $m['nama'] ?>' required></td>
        </tr>
        <tr>
            <td><label>No Kad Pengenalan:</label></td>
            <td><input type='text' name='noKP' value='<?= $m['noKP'] ?>' required></td>
        </tr>
        <tr>
            <td><label>Katalaluan:</label></td>
            <td><input type='text' name='katalaluan' value='<?= $m['katalaluan'] ?>' required></td>
        </tr>
        <tr>
            <td><label>Jenis Pengguna</label></td>
            <td>
                <select name='jenisPengguna' required>
                        <option value='<?= $m['jenisPengguna'] ?>'>
                        <?= $m['jenisPengguna'] ?></option>

<?php
// Dapatkan senarai jenis pengguna tanpa ulangan
$arahan_sql = "SELECT jenisPengguna FROM pengguna GROUP BY jenisPengguna ORDER BY
jenisPengguna";
$laksana_arahan = mysqli_query($condb, $arahan_sql);

while($n = mysqli_fetch_array($laksana_arahan)) {
    if ($n['jenisPengguna'] != $m['jenisPengguna']) {
        echo"<option value='" . $n['jenisPengguna'] . "'>
            ". $n['jenisPengguna'] . "</option>";
    }
}
?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type='submit' value='Kemaskini'>
            </td>
        </tr>
    </table>
</form>
<?php include('footer.php'); ?>