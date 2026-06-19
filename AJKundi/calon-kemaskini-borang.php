<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

// Semak login admin
if (!isset($_SESSION['noKP']) || $_SESSION['jenisPengguna'] !== 'admin') {
    header("location:login.php");
    exit;
}

// Ambil ID calon dari URL
if (!isset($_GET['idCalon']) || empty($_GET['idCalon'])) {
    die("<script>alert('ID Calon tidak ditemui');
        window.location.href='calon-senarai.php';</script>");
}

$idCalon = mysqli_real_escape_string($condb, $_GET['idCalon']);

// Ambil data calon
$query = "SELECT * FROM calon WHERE idCalon='$idCalon'";
$result = mysqli_query($condb, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("<script>alert('Data calon tidak ditemui');
        window.location.href='calon-senarai.php';</script>");
}

$calon = mysqli_fetch_array($result);
$gambar_lama = $calon['gambar'];
?>

<head>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .borang-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .borang-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .borang-header h1 {
            color: #7c3aed;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .borang-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 2px dashed #7c3aed;
            border-radius: 8px;
            background: rgba(124, 58, 237, 0.05);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-input-label:hover {
            background: rgba(124, 58, 237, 0.1);
            border-color: #6d28d9;
        }

        .file-input-label span {
            color: #7c3aed;
            font-weight: 600;
        }

        .preview-image {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 15px;
            border: 2px solid #7c3aed;
        }

        .gambar-lama {
            text-align: center;
            margin-bottom: 15px;
        }

        .gambar-lama p {
            color: #666;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .gambar-lama img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #999;
        }

        .help-text {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn-submit,
        .btn-cancel {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #7c3aed, #06b6d4);
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3);
        }

        .btn-cancel {
            background: #e2e8f0;
            color: #333;
        }

        .btn-cancel:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;
            border: 2px solid #fecaca;
            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;
            border: 2px solid #bbf7d0;
            color: #166534;
        }

        @media (max-width: 600px) {
            .borang-container {
                margin: 20px;
                padding: 20px;
            }

            .borang-header h1 {
                font-size: 24px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>

<div class="borang-container">
    <div class="borang-header">
        <h1>✏️ Edit Data Calon</h1>
        <p>Kemaskini maklumat calon berikut</p>
    </div>

    <form method="POST" action="calon-kemaskini-proses.php" enctype="multipart/form-data">
        <input type="hidden" name="idCalon" value="<?php echo htmlspecialchars($calon['idCalon']); ?>">
        <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($gambar_lama); ?>">

        <div class="form-group">
            <label for="nama_calon">👤 Nama Calon <span style="color: red;">*</span></label>
            <input type="text" id="nama_calon" name="nama_calon" value="<?php echo htmlspecialchars($calon['namaCalon']); ?>" required>
            <div class="help-text">Contoh: Muhammad Ali bin Ahmad</div>
        </div>

        <div class="form-group">
            <label for="jawatan_calon">💼 Jawatan <span style="color: red;">*</span></label>
            <select id="jawatan_calon" name="jawatan_calon" required>
                <option value="">-- Pilih Jawatan --</option>
                <?php
                $query_jawatan = "SELECT * FROM jawatan ORDER BY namaJawatan";
                $result_jawatan = mysqli_query($condb, $query_jawatan);
                
                if ($result_jawatan && mysqli_num_rows($result_jawatan) > 0) {
                    while ($jawatan = mysqli_fetch_array($result_jawatan)) {
                        $selected = ($jawatan['kodJawatan'] == $calon['kodJawatan']) ? 'selected' : '';
                        echo "<option value='" . $jawatan['kodJawatan'] . "' $selected>";
                        echo htmlspecialchars($jawatan['namaJawatan']);
                        echo "</option>";
                    }
                }
                ?>
            </select>
            <div class="help-text">Pilih jawatan untuk calon ini</div>
        </div>

        <div class="form-group">
            <label for="status_calon">🔗 Status <span style="color: red;">*</span></label>
            <select id="status_calon" name="status_calon" required>
                <option value="aktif" <?php echo ($calon['status'] === 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                <option value="tidak-aktif" <?php echo ($calon['status'] === 'tidak-aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>
            <div class="help-text">Pilih status calon</div>
        </div>

        <div class="form-group">
            <label>📷 Gambar Calon</label>
            
            <!-- Gambar Lama -->
            <?php if (!empty($gambar_lama)): ?>
            <div class="gambar-lama">
                <p>Gambar Semasa:</p>
                <img src="gambar/<?php echo htmlspecialchars($gambar_lama); ?>" alt="Gambar Calon Semasa" onerror="this.src='gambar/default.png'">
            </div>
            <?php endif; ?>

            <!-- Upload Gambar Baru -->
            <p style="color: #666; font-size: 13px; margin-bottom: 10px;">Klik di bawah untuk tukar gambar (opsional):</p>
            <div class="file-input-wrapper">
                <input type="file" id="gambar_calon" name="gambar_calon" accept="image/*" onchange="previewImage(event)">
                <label for="gambar_calon" class="file-input-label">
                    <span>📁 Klik untuk pilih atau Drag & Drop gambar di sini</span>
                </label>
            </div>
            <img id="preview" class="preview-image" alt="Preview" style="display: none;">
            <div class="help-text">Format: JPG, JPEG, PNG, GIF (Maksimal 5MB) - Biarkan kosong jika tidak ingin tukar</div>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-submit">💾 Simpan Perubahan</button>
            <a href="calon-senarai.php" class="btn-cancel">❌ Batal</a>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    
    if (file) {
        // Validasi saiz file (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Saiz file terlalu besar! Maksimal 5MB');
            event.target.value = '';
            preview.style.display = 'none';
            return;
        }

        // Validasi jenis file
        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Format fail tidak disokong! Guna JPG, PNG atau GIF');
            event.target.value = '';
            preview.style.display = 'none';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

// Drag & Drop
const fileInput = document.getElementById('gambar_calon');
const fileLabel = fileInput.parentElement.querySelector('.file-input-label');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    fileLabel.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    fileLabel.addEventListener(eventName, () => {
        fileLabel.style.background = 'rgba(124, 58, 237, 0.15)';
    });
});

['dragleave', 'drop'].forEach(eventName => {
    fileLabel.addEventListener(eventName, () => {
        fileLabel.style.background = 'rgba(124, 58, 237, 0.05)';
    });
});

fileLabel.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    fileInput.files = files;
    
    const event = new Event('change', { bubbles: true });
    fileInput.dispatchEvent(event);
});
</script>

<?php include('footer.php'); ?>
