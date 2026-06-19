<?php
session_start();
include('header.php');
include('connection.php');

// Check if user is logged in
if (empty($_SESSION['jenisPengguna']) || $_SESSION['jenisPengguna'] != 'pengundi') {
    header('Location: login.php');
    exit;
}

// Check if user already voted
$noKP = $_SESSION['noKP'];
$semak_undi = mysqli_query($condb, "SELECT * FROM undi WHERE noKPPengundi='" . mysqli_real_escape_string($condb, $noKP) . "'");

if (!$semak_undi) {
    die("Database Error: " . mysqli_error($condb));
}

$sudah_undi = mysqli_num_rows($semak_undi) > 0;

if ($sudah_undi) {
    echo "<div style='text-align:center; margin: 50px auto; max-width: 600px;'>";
    echo "<h2 style='color: #ef4444;'>⚠️ Anda Sudah Mengundi</h2>";
    echo "<p style='font-size: 16px; color: #666;'>Maaf, anda hanya boleh mengundi sekali. Terima kasih atas penyertaan anda.</p>";
    echo "<a href='hasil-undi.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #7c3aed; color: white; text-decoration: none; border-radius: 5px;'>Lihat Pilihan Anda</a>";
    echo "</div>";
    include('footer.php');
    exit;
}

// ✅ Load calon terus dari DATABASE (bukan JSON)
$positions_order = ['Pengerusi', 'Timbalan Pengerusi', 'Setiausaha', 'Bendahari'];
$candidates_by_position = [];

$calon_query = mysqli_query($condb, 
    "SELECT calon.idCalon, calon.namaCalon, calon.gambar, jawatan.namaJawatan
     FROM calon
     JOIN jawatan ON calon.kodJawatan = jawatan.kodJawatan
     WHERE calon.status = 'aktif'
     ORDER BY jawatan.kodJawatan, calon.idCalon"
);

if (!$calon_query) {
    die("Database Error: " . mysqli_error($condb));
}

while ($row = mysqli_fetch_assoc($calon_query)) {
    $pos = $row['namaJawatan'];
    if (!isset($candidates_by_position[$pos])) {
        $candidates_by_position[$pos] = [];
    }
    $candidates_by_position[$pos][] = $row;
}

// Ambil error dari session jika ada
$undi_error = '';
if (!empty($_SESSION['undi_error'])) {
    $undi_error = $_SESSION['undi_error'];
    unset($_SESSION['undi_error']);
}

// Load manifesto dari JSON untuk paparan sahaja (optional)
$manifestos_by_name = [];
if (file_exists('manifesto-data.json')) {
    $json = file_get_contents('manifesto-data.json');
    $manifestos = json_decode($json, true);
    if ($manifestos) {
        foreach ($manifestos as $m) {
            $manifestos_by_name[$m['nama']] = $m['manifesto'] ?? '';
        }
    }
}
?>

<?php if ($undi_error): ?>
<div style="max-width: 800px; margin: 20px auto; padding: 15px 20px; background: #fee2e2; border: 2px solid #ef4444; border-radius: 10px; color: #991b1b; text-align: center; font-size: 15px;">
    ⚠️ <?php echo htmlspecialchars($undi_error); ?>
</div>
<?php endif; ?>

<section class="voting-container">
    <div class="voting-header">
        <h1 class="voting-title">🗳️ Borang Pengundian</h1>
        <p class="voting-subtitle">Sila pilih satu calon untuk setiap jawatan</p>
    </div>

    <form id="votingForm" action="undi-proses.php" method="POST">

        <?php foreach ($positions_order as $position): ?>
            <?php if (isset($candidates_by_position[$position])): ?>

        <div class="jawatan-section">
            <div class="jawatan-title">📌 <?php echo htmlspecialchars($position); ?></div>

            <div class="calon-grid">
                <?php foreach ($candidates_by_position[$position] as $calon): 
                    // Cari manifesto dari JSON berdasarkan nama (untuk paparan sahaja)
                    $manifesto_text = $manifestos_by_name[$calon['namaCalon']] ?? 'Calon ini bersedia untuk berkhidmat.';
                ?>

                <div class="calon-card-wrapper">
                    <!-- ✅ value guna idCalon dari DB -->
                    <input type="radio"
                           id="radio_<?php echo $calon['idCalon']; ?>"
                           name="jawatan_<?php echo str_replace(' ', '_', htmlspecialchars($position)); ?>"
                           value="<?php echo $calon['idCalon']; ?>"
                           data-nama="<?php echo htmlspecialchars($calon['namaCalon']); ?>"
                           class="calon-radio"
                           required
                           onchange="updateCardSelection(this)">

                    <label for="radio_<?php echo $calon['idCalon']; ?>" class="calon-card" onclick="event.preventDefault(); document.getElementById('radio_<?php echo $calon['idCalon']; ?>').checked = true; updateCardSelection(document.getElementById('radio_<?php echo $calon['idCalon']; ?>'));">

                        <div class="calon-image-wrapper">
                            <img src="gambar/<?php echo htmlspecialchars($calon['gambar'] ?? 'default.png'); ?>"
                                 alt="<?php echo htmlspecialchars($calon['namaCalon']); ?>"
                                 class="calon-image"
                                 onerror="this.src='gambar/default.png'">
                        </div>

                        <div class="calon-name"><?php echo htmlspecialchars($calon['namaCalon']); ?></div>

                        <div class="calon-manifesto">
                            <?php echo htmlspecialchars(substr($manifesto_text, 0, 80)) . '...'; ?>
                        </div>

                        <div class="checkmark">✓</div>
                    </label>
                </div>

                <?php endforeach; ?>
            </div>
        </div>

        <?php endif; ?>
        <?php endforeach; ?>

        <!-- VALIDATION MESSAGE -->
        <div class="validation-message" id="validationMessage">
            ⚠️ Sila pilih satu calon untuk setiap jawatan sebelum menghantar
        </div>

        <!-- BUTTON SUBMIT -->
        <div class="button-container">
            <button type="submit" class="btn-submit" onclick="validateForm(event)">
                ✓ Hantar Pengundian Saya
            </button>
        </div>
    </form>
</section>

<style>
.voting-container {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.voting-header {
    text-align: center;
    margin-bottom: 50px;
}

.voting-title {
    font-size: 40px;
    font-weight: 900;
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
}

.voting-subtitle {
    font-size: 18px;
    color: #cbd5e1;
}

.jawatan-section {
    margin-bottom: 50px;
    background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(6, 182, 212, 0.05) 100%);
    border: 2px solid rgba(124, 58, 237, 0.2);
    border-radius: 16px;
    padding: 30px;
}

.jawatan-title {
    font-size: 22px;
    font-weight: bold;
    color: #7c3aed;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 3px solid #7c3aed;
}

.calon-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.calon-card-wrapper {
    position: relative;
}

.calon-radio {
    display: none;
}

.calon-card {
    display: flex;
    flex-direction: column;
    gap: 12px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 15px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.calon-card:hover {
    transform: translateY(-5px);
    border-color: #7c3aed;
    box-shadow: 0 10px 25px rgba(124, 58, 237, 0.2);
}

.calon-radio:checked + .calon-card {
    background: #7c3aed;
    color: white;
    border-color: #7c3aed;
}

.calon-radio:checked + .calon-card .checkmark {
    opacity: 1;
    transform: scale(1);
}

.checkmark {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 28px;
    height: 28px;
    background: #10b981;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 16px;
    opacity: 0;
    transform: scale(0);
    transition: all 0.3s ease;
}

.calon-image-wrapper {
    width: 100%;
    height: 150px;
    overflow: hidden;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(6, 182, 212, 0.1));
}

.calon-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.calon-name {
    font-size: 16px;
    font-weight: bold;
    color: inherit;
}

.calon-manifesto {
    font-size: 12px;
    color: #666;
    line-height: 1.4;
}

.calon-radio:checked + .calon-card .calon-manifesto {
    color: #e2e8f0;
}

.validation-message {
    text-align: center;
    margin-top: 30px;
    padding: 15px;
    background: #fef3c7;
    border: 1px solid #fcd34d;
    border-radius: 8px;
    color: #92400e;
    display: none;
}

.validation-message.show {
    display: block;
}

.button-container {
    text-align: center;
    margin-top: 40px;
}

.btn-submit {
    background: linear-gradient(135deg, #7c3aed, #06b6d4);
    color: white;
    border: none;
    padding: 16px 50px;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: bold;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(124, 58, 237, 0.3);
}

@media (max-width: 768px) {
    .voting-title { font-size: 28px; }
    .jawatan-title { font-size: 18px; }
    .calon-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
    .calon-image-wrapper { height: 120px; }
}

@media (max-width: 480px) {
    .voting-title { font-size: 24px; }
    .jawatan-section { padding: 20px; margin-bottom: 30px; }
    .calon-grid { grid-template-columns: 1fr; }
    .calon-name { font-size: 14px; }
    .calon-manifesto { font-size: 11px; }
}
</style>

<script>
function updateCardSelection(radioElement) {
    const groupName = radioElement.name;
    const allRadios = document.querySelectorAll(`input[name="${groupName}"]`);
    allRadios.forEach(radio => {
        const card = radio.nextElementSibling;
        if (card) card.classList.remove('checked');
    });
    if (radioElement.checked && radioElement.nextElementSibling) {
        radioElement.nextElementSibling.classList.add('checked');
    }
}

function validateForm(e) {
    const form = document.getElementById('votingForm');
    const inputs = form.querySelectorAll('input[type="radio"][required]');
    const groups = {};

    inputs.forEach(input => {
        if (!groups[input.name]) groups[input.name] = false;
        if (input.checked) groups[input.name] = true;
    });

    const allSelected = Object.values(groups).every(v => v);

    if (!allSelected) {
        e.preventDefault();
        document.getElementById('validationMessage').classList.add('show');
        setTimeout(() => {
            document.getElementById('validationMessage').classList.remove('show');
        }, 4000);
        return false;
    }

    if (!confirm('Anda pasti dengan pilihan ini?')) {
        e.preventDefault();
        return false;
    }

    return true;
}
</script>

<?php include('footer.php'); ?>
