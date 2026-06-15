<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

$fail = 'manifesto-data.json';

// JSON
$manifestoMap = [];
if (file_exists($fail)) {
    $json = file_get_contents($fail);
    $data = json_decode($json, true);
    if (is_array($data)) $manifestoMap = $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noCalon = isset($_POST['noCalon']) ? trim($_POST['noCalon']) : '';
    $manifesto = isset($_POST['manifesto']) ? trim($_POST['manifesto']) : '';

    if ($noCalon !== '') {
        if ($manifesto === '') {
            unset($manifestoMap[$noCalon]);
        } else {
            $manifestoMap[$noCalon] = $manifesto;
        }

        file_put_contents($fail, json_encode($manifestoMap, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT), LOCK_EX);

        echo "<script>alert('Manifesto berjaya dikemaskini!');</script>";
    }
}
// Untuk Senari Calon
$sql = "SELECT calon.noCalon, calon.namaCalon, jawatan.namaJawatan
        FROM calon
        JOIN jawatan ON calon.kodJawatan = jawatan.kodJawatan
        ORDER BY jawatan.kodJawatan, calon.namaCalon";
$q = mysqli_query($condb, $sql);

$pilih = isset($_GET['noCalon']) ? trim($_GET['noCalon']) : '';
$prefill = ($pilih !== '' && isset($manifestoMap[$pilih])) ? $manifestoMap[$pilih] : '';
?>

<h2 style="text-align:center; font-size:30px; margin-top:25px;">Kemaskini Manifesto</h2>

<form method="GET" style="text-align:center; margin-top:15px;">
    <select name="noCalon" class="input" required>
        <option value="" disabled <?php echo ($pilih===''?'selected':''); ?>>Pilih Calon</option>
        <?php while ($m = mysqli_fetch_array($q)) {
            $id = (string)$m['noCalon'];
            $sel = ($id === $pilih) ? "selected" : "";
            echo "<option value='".htmlspecialchars($id)."' $sel>"
                .htmlspecialchars($m['namaJawatan'])." - ".htmlspecialchars($m['namaCalon'])
                ."</option>";
        } ?>
    </select>
    <input style='font-size: 15px;padding: 12px 26px;background: darkblue;color: white;border: none;border-radius: 10px;cursor: pointer;' type="submit" value="Pilih">
</form>

<?php if ($pilih !== '') { ?>
    <form method="POST" style="margin: 20px auto; width:min(900px, 95vw);">
        <input type="hidden" name="noCalon" value="<?php echo htmlspecialchars($pilih); ?>">

        <div style="margin-bottom:10px; font-weight:bold;">Manifesto:</div>
        <textarea name="manifesto" rows="10" style="width:100%; padding:12px; border-radius:14px; border:2px solid darkblue; background-color:aliceblue;"><?php
            echo htmlspecialchars($prefill);
        ?></textarea>

        <div style="margin-top:10px; display:flex; gap:10px; justify-content:center;">
            <input style='font-size: 15px;padding: 12px 26px;background: darkblue;color: white;border: none;border-radius: 10px;cursor: pointer;' type="submit" value="Simpan">
            <a class="nav" href="manifesto.php">Lihat Manifesto</a>
        </div>
    </form>
<?php } ?>

<?php include('footer.php'); ?>