<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');
?>

<style>
    body{
        overflow-x: hidden;
        overflow-y: auto;      
}
</style>
<!-- Borang Pendaftaran Calon -->

<form class="form" action="calon-daftar-proses.php" method="POST" enctype="multipart/form-data">
    <p class="title">Pendaftaran Calon Baru</p>
    <p class="message">Sila isi maklumat calon di bawah</p>

    <label class="field">
        <input class="finput" type="text" name="nama_calon_baru" required placeholder=" ">
        <span>Nama Calon</span>
    </label>

    <label class="field">
        <select class="finput" name="jawatan_calon_baru" required>
        <option value="" disabled selected>Pilih Jawatan</option>
    <?php
        $jawatan_query = "SELECT * FROM jawatan ORDER BY kodJawatan";
        $jawatan_result = mysqli_query($condb, $jawatan_query);
        while ($jawatan = mysqli_fetch_array($jawatan_result)) {
            echo "<option value='".$jawatan['kodJawatan']."'>".$jawatan['namaJawatan']."</option>";
    }
    ?>
    </select>
    <span>Jawatan</span>
    </label>

    <label class="field">
        <input class="finput" type="file" name="gambar_calon" accept="image/*" required>
        <span>Gambar Calon</span>
    </label>

    <button class="btn-primary" type="submit">Daftar</button>
</form>

<!-- Paparan Senarai Calon -->
<table class="table-calon" style="border-color: darkblue;"  align='center' width='100%' border='1' id='saiz'>  

    <tr>
    <th colspan="4" class="table-title">Senarai Calon</th>
    </tr>

    <tr bgcolor='lightsteelblue' style="color: black;">
        <td colspan='1'>
            <form action='' method='POST' style="margin:0; padding:0">
                <input class="input-senarai" type='text' name='namaCalon' placeholder='Carian Nama Calon'>
                <input style='font-size: 11px;padding: 9px 9px;background: darkblue;color: white;border: none;border-radius: 10px;cursor: pointer;' type='submit' value='Cari'>
            </form>
        </td>
        <td colspan='4' align='right' style="color: black;">
            <?php include('butang-saiz.php'); ?>
        </td>
    </tr>
    <tr align='center' bgcolor='lightsteelblue' style="color: black;">
        <td width='10%'><b>Gambar</b></td>
        <td width='35%'><b>Nama</b></td>
        <td width='10%'><b>Jawatan Calon</b></td>
        <td width='20%'><b>Tindakan</b></td>
    </tr>
<?php
// Tambahkan pada syarat SQL untuk carian nama calon
$tambahan = !empty($_POST['namaCalon']) ? 
            " AND calon.namaCalon LIKE '%".$_POST['namaCalon']."%'" : "";
// Papar calon berserta jawatan mereka
$arahan_papar = "SELECT * FROM calon, jawatan
                WHERE calon.kodJawatan = jawatan.kodJawatan
                $tambahan ORDER BY jawatan.kodJawatan";
$laksana = mysqli_query($condb, $arahan_papar);
while ($m = mysqli_fetch_array($laksana)) {
    echo "<tr align='center'>
        <td><img src='gambar/".$m['gambar']."' style='width: 100px; height: 100px; border-radius:5px;'> </td>
        <td>".$m['namaCalon']."</td>
        <td>".$m['namaJawatan']."</td>
        <td>| <a href='calon-padam.php?noCalon=".$m['noCalon']."' onClick=\"return confirm('Anda pasti ingin memadam data ini?')\">Hapus</a> |
        </td>
    </tr>";
} ?>
</table>
<?php include('footer.php'); ?>