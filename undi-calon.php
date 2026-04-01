<head>
<link rel="stylesheet" href="css/style.css">
</head>

<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');
?>
<br><br><br>
<table class="table-pengguna" style="border-color: darkblue;" align='center' width='100%' border='1' id='saiz' >
    <tr>
    <th colspan="5 " class="table-title">Senarai Pengguna</th>
    </tr>

    <tr bgcolor='lightsteelblue'>
        <td colspan='1'>
            <!-- Borang carian pengguna -->
            <form action='' method='POST' style="margin:0; padding:0">
                <input class="input-senarai" type='text' name='nama' placeholder='Carian Nama Pengguna'>
                <input style='font-size: 11px;padding: 10px 10px;background: darkblue;color: white;border: none;border-radius: 10px;cursor: pointer;' type='submit' value='Cari'>
            </form>
        </td>
        <td style="color: black;" colspan='4' align='right'>
            | <b><a href='pengguna-upload.php' style="color:black;">Muat Naik Data Pengguna</a></b>
            <?php include('butang-saiz.php'); ?>
        </td>
    </tr>
    <tr style="color: black;" align='center' bgcolor='lightsteelblue'>
        <td width='35%'><b>Nama</b></td>
        <td width='15%'><b>No Kad Pengenalan</b></td>
        <td width='10%'><b>KataLaluan</b></td>
        <td width='10%'><b>Jenis Pengguna</b></td>
        <td width='20%'><b>Tindakan</b></td>
    </tr>

<?php
// Tambah syarat dalam carian pengguna melalui nama
$tambahan = !empty($_POST['nama'])
    ? " WHERE [pengguna.nama LIKE '%" . $_POST['nama'] . "%'" : "";

// Arahan SQL untuk carian data pengguna
$arahan_papar = "SELECT * FROM pengguna $tambahan ORDER BY jenisPengguna";
$laksana = mysqli_query($condb, $arahan_papar);

// Paparkan setiap rekod pengguna
while($m = mysqli_fetch_array($laksana)) {
    echo "<tr>
        <td>".$m['nama']."</td>
        <td>".$m['noKP']."</td>
        <td>".$m['katalaluan']."</td>
        <td>".$m['jenisPengguna']."</td>
        <td>
| <a href='pengguna-kemaskini-borang.php?noKP=".$m['noKP']."'> Kemaskini </a>

| <a href='pengguna-padam.php?noKP=".$m['noKP']."'
        onClick=\"return confirm('Anda pasti ingin memadan data ini?')\">Hapus</a>        
        
        </td>
    </tr>";
}
?>
</table>
<?php include('footer.php'); ?>