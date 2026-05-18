 url=https://github.com/m-10392980-byte/te
<?php
session_start();
include('header.php');
include('connection.php');

// Semak login
if (!isset($_SESSION['noKP'])) {
    header("location:login.php");
    exit;
}

// Semak pengguna sudah mengundi atau tidak
$noKP = $_SESSION['noKP'];
$semak_undi = mysqli_query($condb, "SELECT * FROM undian WHERE noKP='$noKP'");
$sudah_undi = mysqli_num_rows($semak_undi) > 0;

// Jika sudah mengundi, papar pesan
if ($sudah_undi) {
    echo "<div style='text-align:center; margin: 50px auto; max-width: 600px;'>";
    echo "<h2 style='color: #ef4444;'>⚠️ Anda Sudah Mengundi</h2>";
    echo "<p style='font-size: 16px; color: #666;'>Maaf, anda hanya boleh mengundi sekali. Terima kasih atas penyertaan anda.</p>";
    echo "<a href='index.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #7c3aed; color: white; text-decoration: none; border-radius: 5px;'>Kembali ke Halaman Utama</a>";
    echo "</div>";
    include('footer.php');
    exit;
}
?>

<head>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .voting-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .voting-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .voting-header h1 {
            color: #7c3aed;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .voting-header p {
            color: #666;
            font-size: 16px;
        }

        .jawatan-section {
            margin-bottom: 40px;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(6, 182, 212, 0.05) 100%);
            border: 2px solid rgba(124, 58, 237, 0.2);
            border-radius: 16px;
            padding: 30px;
        }

        .jawatan-title {
            font-size: 20px;
            font-weight: bold;
            color: #7c3aed;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #7c3aed;
        }

        .calon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .calon-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .calon-card:hover {
            transform: translateY(-5px);
            border-color: #7c3aed;
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.2);
        }

        .calon-card.selected {
            background: #7c3aed;
            color: white;
            border-color: #7c3aed;
        }

        .calon-image {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            margin-bottom: 15px;
            object-fit: cover;
        }

        .calon-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .calon-jawatan {
            font-size: 12px;
            color: #999;
        }

        .calon-card.selected .calon-jawatan {
            color: #e2e8f0;
        }

        .button-container {
            text-align: center;
            margin-top: 40px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #7c3aed, #06b6d4);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.3);
        }

        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .validation-message {
            text-align: center;
            margin-top: 20px;
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

        @media (max-width: 768px) {
            .calon-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }

            .calon-image {
                width: 100px;
                height: 100px;
            }

            .voting-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<div class="voting-container">
    <div class="voting-header">
        <h1>🗳️ Borang Pengundian</h1>
        <p>Sila pilih satu calon untuk setiap jawatan</p>
    </div>

    <form id="votingForm" action="undi-voting-proses.php" method="POST">
        <?php
        // Ambil semua jawatan
        $jawatan_query = "SELECT * FROM jawatan ORDER BY kodJawatan";
        $jawatan_result = mysqli_query($condb, $jawatan_query);

        while ($jawatan = mysqli_fetch_array($jawatan_result)) {
            $kodJawatan = $jawatan['kodJawatan'];
            $namaJawatan = $jawatan['namaJawatan'];

            echo "<div class='jawatan-section'>";
            echo "<div class='jawatan-title'>" . $namaJawatan . "</div>";
            echo "<div class='calon-grid'>";

            // Ambil calon untuk jawatan ini
            $calon_query = "SELECT * FROM calon WHERE kodJawatan='$kodJawatan' ORDER BY namaCalon";
            $calon_result = mysqli_query($condb, $calon_query);

            while ($calon = mysqli_fetch_array($calon_result)) {
                $noCalon = $calon['noCalon'];
                $namaCalon = $calon['namaCalon'];
                $gambar = $calon['gambar'];

                echo "<label class='calon-card' onclick='selectCalon(this, $kodJawatan, $noCalon)'>";
                echo "<input type='radio' name='jawatan_$kodJawatan' value='$noCalon' style='display:none;' required>";
                echo "<img src='gambar/$gambar' alt='$namaCalon' class='calon-image'>";
                echo "<div class='calon-name'>$namaCalon</div>";
                echo "<div class='calon-jawatan'>$namaJawatan</div>";
                echo "</label>";
            }

            echo "</div>";
            echo "</div>";
        }
        ?>

        <div class="validation-message" id="validationMessage">
            ⚠️ Sila pilih satu calon untuk setiap jawatan sebelum menghantar
        </div>

        <div class="button-container">
            <button type="submit" class="btn-submit" onclick="validateForm(event)">
                ✓ Hantar Pengundian Saya
            </button>
        </div>
    </form>
</div>

<script>
function selectCalon(element, jawatan, noCalon) {
    // Hapus selected dari card-card lain dalam section yang sama
    const section = element.parentElement;
    const cards = section.querySelectorAll('.calon-card');
    cards.forEach(card => card.classList.remove('selected'));
    
    // Tambah selected ke card yang dipilih
    element.classList.add('selected');
    
    // Set radio button
    const radio = element.querySelector('input[type="radio"]');
    radio.checked = true;
}

function validateForm(e) {
    const form = document.getElementById('votingForm');
    const inputs = form.querySelectorAll('input[type="radio"][required]');
    
    let allSelected = true;
    inputs.forEach(input => {
        if (!input.checked) {
            allSelected = false;
        }
    });

    if (!allSelected) {
        e.preventDefault();
        document.getElementById('validationMessage').classList.add('show');
        setTimeout(() => {
            document.getElementById('validationMessage').classList.remove('show');
        }, 3000);
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