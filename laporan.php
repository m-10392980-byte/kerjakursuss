<head>
<link rel="stylesheet" href="css/style.css">
</head>

<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

// proses tambah jawatan baharu
if(!empty($_POST['nama_jawatan_baru'])) {

    $nama_jawatan_baru = mysqli_real_escape_string($condb, $_POST['nama_jawatan_baru']);

    // proses tambah ke jadual jawatan
    $arahan_tambah = "INSERT INTO jawatan (namaJawatan)
                        VALUES ('$nama_jawatan_baru')";
    if (mysqli_query($condb, $arahan_tambah)) {
        echo"<script>
                alert('Jawatan Berjaya Ditambah');
                window.location.href='jawatan-tambah.php';
            </script>";
    } else {
        echo $arahan_tambah . mysqli_error($condb);
        echo "<script>alert('Jawatan Gagal Ditambah');</script>";
    }
}
// Prosed padam jawatan
if (!empty($_GET['kodJawatan'])) {

    $kodJawatan = mysqli_real_escape_string($condb, $_GET['kodJawatan']);
    // proses padam berdasarkan kodJawatan
    $arahan_padam = "DELETE FROM jawatan WHERE kodJawatan='$kodJawatan'";

    // Laksanakan padam
    if (mysqli_query($condb, $arahan_padam)) {
        echo"<script>
                alert('Jawatan Berjaya Dipadam');
                window.location.href='jawatan-tambah.php';
            </script>";
    } else {
        echo"<script>
                alert('Jawatan Gagal Dipadam')
                window.location.href='jawatan-tambah.php';
            </script>";
    }
}
?>

<!-- Borang tambah jawatan -->

<h3 align='center'>Senarai Jawatan</h3>

<table align='center' width='50%' border='1'>
    <caption>
        <form action='jawatan-tambah.php' method='POST' align='center'>
            <input type='text' name='nama_jawatan_baru' placeholder='Nama Jawatan Baru' required>
            <input type='submit' value='Tambah'>
        </form>
    </caption>
    <tr bgcolor='cyan'>
        <td>Nama Jawatan</td>
        <td>Tindakan</td>
    </tr>
    <?php
    // Paparkan semua jawatan
    $arahan_papar = "SELECT * FROM jawatan ORDER BY kodJawatan";
    $laksana = mysqli_query($condb, $arahan_papar);
    while ($jawatan = mysqli_fetch_array($laksana)) {
        echo "<tr>
                <td>" . $jawatan['namaJawatan'] . "</td>
                <td>
                <a href='jawatan-tambah.php?kodJawatan=" . $jawatan['kodJawatan'] . "'
                onClick=\"return confirm('Anda pasti ingin memadam jawatan ini?')\">Hapus</a>
                
                </td>
        </tr>";
    } ?>
</table>
<?php include('footer.php'); ?>