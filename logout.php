<head>
<link rel="stylesheet" href="css/style.css">
</head>

<?php
session_start();
include('header.php');
include('connection.php');
?>
<!-- Tajuk -->
<h3 align='center' style="font-size: 30px; position: relative;">Laporan Keputusan Undian</h3>

<!-- Borang pilihan jawatan -->
<form method='POST' align='center' style="width: 1445px;">
    <select class="pilih" name='kodJawatan' required>
        <option value='' disabled selected>Pilih Jawatan</option>
        <option value='semua'>KEPUTUSAN UNDIAN</option>
        <?php
        // Paparkan semua jawatan dalam dropdown
        $arahan_jawatan = "SELECT * FROM jawatan ORDER BY kodJawatan";
        $laksana_jawatan = mysqli_query($condb, $arahan_jawatan);
        while ($jawatan = mysqli_fetch_array($laksana_jawatan)) {
            echo "<option value='".$jawatan['kodJawatan']."'>
                    ".$jawatan['namaJawatan']."</option>";
        }
        ?>
    </select>
    <input style='font-size: 15px;padding: 12px 26px;background: darkblue;color: white;border: none;border-radius: 10px;cursor: pointer;' class="papar" type='submit' value='Papar'>
</form>

<?php
// Proses apabila borang dihantar
if (!empty($_POST['kodJawatan'])) {
    // Penapisan asas input
    $kodJawatan = mysqli_real_escape_string($condb, $_POST['kodJawatan']);

    // Jika paparan untuk semua jawatan
    if ($kodJawatan === 'semua') {
        echo "<div align='center'><h2>Pemenang Undian Ahli Jawatankuasa AJK Kadet Polis</h2>";
        
        $sql_jawatan = " SELECT * FROM jawatan ORDER BY kodJawatan";
        $laksana_jawatan = mysqli_query($condb, $sql_jawatan);
        while ($jawatan = mysqli_fetch_array($laksana_jawatan)) {
            echo "<h3 align='center'>".$jawatan['namaJawatan']."</h3>";
            echo "<table class='table-keputusan' border='1' align='center' width='50%'>";
            echo "<tr><th width='70%'>Calon</th>
                    <th width='30%'>Bilangan Undian</th></tr>";

        // Paparkan calon dan bilangan undi
        $arahan_calon = "
            SELECT calon.namaCalon,
                    (SELECT COUNT(*) FROM undian
                    WHERE undian.noCalon = calon.noCalon) AS bilangan_undi
            FROM calon
            WHERE calon.kodJawatan = '".$jawatan['kodJawatan']."'
            ORDER BY bilangan_undi DESC";
        $laksana_calon = mysqli_query($condb, $arahan_calon);
        // Tentukan calon tertinggi
        $calon_tertinggi = [];
        $undian_tertinggi = 0;

        while ($calon = mysqli_fetch_array($laksana_calon)) {
            if ($calon['bilangan_undi'] > $undian_tertinggi) {
                $calon_tertinggi = [$calon['namaCalon']];
                $undian_tertinggi = $calon['bilangan_undi'];
            } elseif ($calon['bilangan_undi'] == $undian_tertinggi) {
                $calon_tertinggi[] = $calon['namaCalon'];
            }
        }

        foreach ($calon_tertinggi as $namaCalon) {
            echo "<tr><td>".$namaCalon."</td>
                    <td align='center'>".$undian_tertinggi."</td></tr>";
        }
        echo "</table></div>";
        }
        // Jika paparan hanya untuk satu jawatan
        } else {
            // Dapatkan maklumat jawatan
            $arahan_jawatan = "SELECT * FROM jawatan
                                WHERE kodJawatan = '$kodJawatan'";
            $jawatan = mysqli_fetch_array(mysqli_query($condb, $arahan_jawatan));

            echo"<div align='center'><h2>Keputusan Undian :
                ".$jawatan['namaJawatan']."</h2>";
            echo"<table class='table-keputusan' border='1' width='50%' align='center'>";
            echo"<tr>
                    <th width='70%'>Calon</th>
                    <th width='30%'>Bilangan Undian</th></tr>";
            
            // Dapatkan senarai calon dan bilangan undian
            $arahan_calon = "SELECT calon.namaCalon, calon.gambar,
                            (SELECT COUNT(*) FROM undian
                            WHERE undian.noCalon = calon.noCalon) AS bilangan_undi
                            FROM calon
                            WHERE calon.kodJawatan = '$kodJawatan'
                            ORDER BY bilangan_undi DESC ";

            $laksana_calon = mysqli_query($condb, $arahan_calon);
            while ($calon = mysqli_fetch_array($laksana_calon)) {
                echo"<tr align='center'><td>".$calon['namaCalon']."</td>
                    <td align='center'>".$calon['bilangan_undi']."</td></tr>";
            }
            echo "</table></div>";
        }
    }
include('footer.php');
?>  