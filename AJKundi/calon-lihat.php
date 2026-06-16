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
$query = "SELECT c.*, j.namaJawatan FROM calon c 
          LEFT JOIN jawatan j ON c.kodJawatan = j.kodJawatan 
          WHERE c.idCalon='$idCalon'";
$result = mysqli_query($condb, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("<script>alert('Data calon tidak ditemui');
        window.location.href='calon-senarai.php';</script>");
}

$calon = mysqli_fetch_array($result);
?>

<head>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .detail-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .detail-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .detail-header h1 {
            color: #7c3aed;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .detail-header p {
            color: #666;
            font-size: 14px;
        }

        .detail-gambar {
            text-align: center;
            margin-bottom: 30px;
        }

        .detail-gambar img {
            width: 200px;
            height: 250px;
            object-fit: cover;
            border-radius: 12px;
            border: 4px solid #7c3aed;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .detail-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-item {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #7c3aed;
            font-size: 14px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info-value {
            color: #333;
            font-size: 16px;
            word-break: break-word;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-aktif {
            background: #dcfce7;
            color: #166534;
        }

        .status-tidak-aktif {
            background: #fee2e2;
            color: #991b1b;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn-edit,
        .btn-kembali {
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

        .btn-edit {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            color: white;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-kembali {
            background: #e2e8f0;
            color: #333;
        }

        .btn-kembali:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }

        @media (max-width: 600px) {
            .detail-container {
                margin: 20px;
                padding: 20px;
            }

            .detail-header h1 {
                font-size: 24px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>

<div class="detail-container">
    <div class="detail-header">
        <h1>👁️ Lihat Detail Calon</h1>
        <p>Maklumat lengkap calon yang dipilih</p>
    </div>

    <div class="detail-gambar">
        <?php
        $gambar = !empty($calon['gambar']) ? 'gambar/' . htmlspecialchars($calon['gambar']) : 'gambar/default.png';
        ?>
        <img src="<?php echo $gambar; ?>" alt="Gambar Calon" onerror="this.src='gambar/default.png'">
    </div>

    <div class="detail-info">
        <div class="info-item">
            <div class="info-label">📝 Nama Calon</div>
            <div class="info-value"><?php echo htmlspecialchars($calon['namaCalon']); ?></div>
        </div>

        <div class="info-item">
            <div class="info-label">💼 Jawatan</div>
            <div class="info-value"><?php echo htmlspecialchars($calon['namaJawatan'] ?? 'Tidak Diketahui'); ?></div>
        </div>

        <div class="info-item">
            <div class="info-label">📅 Tarikh Daftar</div>
            <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($calon['tarikhDaftar'])); ?></div>
        </div>

        <div class="info-item">
            <div class="info-label">🔗 Status</div>
            <div class="info-value">
                <?php
                $status_class = $calon['status'] === 'aktif' ? 'status-aktif' : 'status-tidak-aktif';
                echo "<span class='status-badge $status_class'>" . htmlspecialchars($calon['status']) . "</span>";
                ?>
            </div>
        </div>
    </div>

    <div class="button-group">
        <a href="calon-kemaskini-borang.php?idCalon=<?php echo urlencode($calon['idCalon']); ?>" class="btn-edit">✏️ Edit</a>
        <a href="calon-senarai.php" class="btn-kembali">← Kembali</a>
    </div>
</div>

<?php include('footer.php'); ?>
