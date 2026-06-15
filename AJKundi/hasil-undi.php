<?php
session_start();
include('header.php');
include('connection.php');

// Semak login
if (!isset($_SESSION['noKP'])) {
    header("location:login.php");
    exit;
}

$noKP = $_SESSION['noKP'];
$nama_user = $_SESSION['nama'] ?? 'Pengguna';
$jenis_pengguna = $_SESSION['jenisPengguna'] ?? '';

// Ambil data pengguna
$user_query = mysqli_query($condb, "SELECT * FROM pengguna WHERE noKP='" . mysqli_real_escape_string($condb, $noKP) . "'");

if (!$user_query) {
    die("Database Error: " . mysqli_error($condb));
}

$user_data = mysqli_fetch_array($user_query);
if ($user_data) {
    $nama_user = $user_data['nama'];
    $jenis_pengguna = $user_data['jenisPengguna'];
}
?>

<head>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .hasil-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .hasil-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .hasil-header h1 {
            color: #7c3aed;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .user-info {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border: 2px solid rgba(124, 58, 237, 0.3);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .user-info p {
            font-size: 16px;
            color: #333;
            margin: 5px 0;
        }

        .hasil-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .hasil-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .hasil-jawatan {
            font-size: 14px;
            color: #7c3aed;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #7c3aed;
        }

        .hasil-content {
            display: flex;
            gap: 15px;
        }

        .hasil-image {
            width: 80px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .hasil-info h3 {
            font-size: 16px;
            margin: 0 0 8px 0;
            color: #333;
        }

        .hasil-info p {
            font-size: 12px;
            color: #666;
            margin: 0;
        }

        .results-summary {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.08) 0%, rgba(6, 182, 212, 0.08) 100%);
            border: 2px solid rgba(124, 58, 237, 0.3);
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
        }

        .results-title {
            font-size: 20px;
            font-weight: bold;
            color: #7c3aed;
            margin-bottom: 20px;
        }

        .jawatan-results {
            margin-bottom: 25px;
        }

        .jawatan-results h4 {
            font-size: 16px;
            color: #333;
            margin-bottom: 12px;
        }

        .vote-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: white;
            border-radius: 8px;
            margin-bottom: 8px;
            border-left: 4px solid #7c3aed;
        }

        .vote-name {
            font-weight: 500;
            color: #333;
        }

        .vote-count {
            background: #7c3aed;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
        }

        .no-votes {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }

        .button-container {
            text-align: center;
            margin-top: 30px;
        }

        .btn-back {
            background: #7c3aed;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #6d28d9;
            transform: translateY(-2px);
        }

        .admin-message {
            background: #dbeafe;
            border: 1px solid #93c5fd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            color: #1e40af;
        }

        .chart-bar {
            background: linear-gradient(90deg, #7c3aed, #06b6d4);
            height: 30px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .hasil-grid {
                grid-template-columns: 1fr;
            }

            .hasil-header h1 {
                font-size: 24px;
            }

            .results-summary {
                padding: 15px;
            }
        }
    </style>
</head>

<div class="hasil-container">
    <div class="hasil-header">
        <h1>📊 Hasil Pengundian</h1>
    </div>

    <?php
    // Jika admin, tunjuk hasil untuk semua
    if ($jenis_pengguna === 'admin') {
        echo "<div class='admin-message'>
                ℹ️ Anda melihat sebagai ADMIN - Paparan hasil keseluruhan semua pengundi
              </div>";
        
        echo "<div class='results-summary'>";
        echo "<div class='results-title'>Keputusan Akhir Pengundian</div>";

        // Ambil semua jawatan
        $jawatan_query = "SELECT * FROM jawatan ORDER BY kodJawatan";
        $jawatan_result = mysqli_query($condb, $jawatan_query);

        if (!$jawatan_result) {
            die("Database Error: " . mysqli_error($condb));
        }

        while ($jawatan = mysqli_fetch_array($jawatan_result)) {
            $kodJawatan = $jawatan['kodJawatan'];
            $namaJawatan = $jawatan['namaJawatan'];

            echo "<div class='jawatan-results'>";
            echo "<h4>" . htmlspecialchars($namaJawatan) . "</h4>";

            // Ambil hasil vote untuk jawatan ini - FIXED QUERY
            $hasil_query = "SELECT calon.namaCalon, calon.gambar, COUNT(undi.idCalon) as jumlah_vote
                           FROM calon
                           LEFT JOIN undi ON calon.idCalon = undi.idCalon
                           WHERE calon.kodJawatan = " . (int)$kodJawatan . "
                           GROUP BY calon.idCalon
                           ORDER BY jumlah_vote DESC";
            $hasil_result = mysqli_query($condb, $hasil_query);

            if (!$hasil_result) {
                die("Database Error: " . mysqli_error($condb));
            }

            if (mysqli_num_rows($hasil_result) > 0) {
                // Ambil jumlah vote tertinggi untuk referensi
                $max_votes = 0;
                $temp_data = [];
                while ($row = mysqli_fetch_array($hasil_result)) {
                    $temp_data[] = $row;
                    if ($row['jumlah_vote'] > $max_votes) {
                        $max_votes = $row['jumlah_vote'];
                    }
                }

                // Tampilkan hasil
                foreach ($temp_data as $hasil) {
                    $percentage = $max_votes > 0 ? ($hasil['jumlah_vote'] / $max_votes) * 100 : 0;
                    echo "<div class='vote-item'>";
                    echo "<div class='vote-name'>" . htmlspecialchars($hasil['namaCalon']) . "</div>";
                    echo "<div class='vote-count'>" . $hasil['jumlah_vote'] . " vote</div>";
                    echo "</div>";
                    echo "<div class='chart-bar' style='width: " . $percentage . "%;'></div>";
                }
            } else {
                echo "<div class='no-votes'>Tiada data pengundian</div>";
            }

            echo "</div>";
        }

        echo "</div>";

    } else {
        // Jika user biasa, tunjuk pilihan dia sahaja - TIADA statistik keseluruhan
        echo "<div class='user-info'>";
        echo "<p><strong>Nama Pengundi:</strong> " . htmlspecialchars($nama_user) . "</p>";
        echo "<p><strong>No. Kad Pengenalan:</strong> " . htmlspecialchars($noKP) . "</p>";
        echo "</div>";

        // Ambil pilihan pengguna - FIXED QUERY
        $pilihan_query = "SELECT undi.idCalon, calon.namaCalon, calon.gambar, jawatan.namaJawatan, jawatan.kodJawatan
                         FROM undi
                         JOIN calon ON undi.idCalon = calon.idCalon
                         JOIN jawatan ON calon.kodJawatan = jawatan.kodJawatan
                         WHERE undi.noKPPengundi = '" . mysqli_real_escape_string($condb, $noKP) . "'
                         ORDER BY jawatan.kodJawatan";
        $pilihan_result = mysqli_query($condb, $pilihan_query);

        if (!$pilihan_result) {
            die("Database Error: " . mysqli_error($condb));
        }

        if (mysqli_num_rows($pilihan_result) > 0) {
            echo "<div class='hasil-grid'>";
            while ($pilihan = mysqli_fetch_array($pilihan_result)) {
                echo "<div class='hasil-card'>";
                echo "<div class='hasil-jawatan'>" . htmlspecialchars($pilihan['namaJawatan']) . "</div>";
                echo "<div class='hasil-content'>";
                echo "<img src='gambar/" . htmlspecialchars($pilihan['gambar']) . "' alt='" . htmlspecialchars($pilihan['namaCalon']) . "' class='hasil-image'>";
                echo "<div class='hasil-info'>";
                echo "<h3>" . htmlspecialchars($pilihan['namaCalon']) . "</h3>";
                echo "<p>✓ Pilihan anda untuk " . htmlspecialchars($pilihan['namaJawatan']) . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<div style='text-align: center; padding: 40px;'>";
            echo "<p style='font-size: 16px; color: #666;'>Anda belum melakukan pengundian. Sila pergi ke halaman pengundian untuk memilih calon anda.</p>";
            echo "</div>";
        }
    }
    ?>

    <div class="button-container">
        <a href="index.php" class="btn-back">← Kembali ke Halaman Utama</a>
    </div>
</div>

<?php include('footer.php'); ?>
