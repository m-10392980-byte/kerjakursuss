 url=https://github.com/m-10392980-byte/te
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
?>

<head>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .laporan-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .laporan-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .laporan-header h1 {
            color: #7c3aed;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border: 2px solid rgba(124, 58, 237, 0.3);
            border-radius: 12px;
            padding: 25px;
            text-align: center;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            background: linear-gradient(135deg, #7c3aed, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .results-section {
            background: white;
            border: 2px solid rgba(124, 58, 237, 0.2);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 40px;
        }

        .results-title {
            font-size: 24px;
            font-weight: bold;
            color: #7c3aed;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #7c3aed;
        }

        .jawatan-section {
            margin-bottom: 40px;
        }

        .jawatan-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            padding: 15px;
            background: rgba(124, 58, 237, 0.1);
            border-radius: 8px;
            border-left: 4px solid #7c3aed;
        }

        .candidate-result {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 12px;
            border-left: 4px solid #7c3aed;
        }

        .candidate-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .candidate-image {
            width: 60px;
            height: 75px;
            border-radius: 6px;
            object-fit: cover;
        }

        .candidate-name {
            font-weight: 600;
            color: #333;
        }

        .votes-bar-container {
            flex: 2;
            margin: 0 20px;
        }

        .votes-bar {
            background: linear-gradient(90deg, #7c3aed, #06b6d4);
            height: 25px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            color: white;
            font-weight: bold;
            font-size: 12px;
            padding-right: 10px;
            min-width: 30px;
        }

        .votes-count {
            background: #7c3aed;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
            min-width: 60px;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #999;
            font-style: italic;
            background: #f8f9fa;
            border-radius: 8px;
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
            margin-right: 10px;
        }

        .btn-back:hover {
            background: #6d28d9;
            transform: translateY(-2px);
        }

        .btn-print {
            background: #10b981;
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

        .btn-print:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .candidate-result {
                flex-direction: column;
                align-items: flex-start;
            }

            .votes-bar-container {
                width: 100%;
                margin: 10px 0;
            }

            .votes-count {
                margin-top: 10px;
            }

            .laporan-header h1 {
                font-size: 24px;
            }
        }

        @media print {
            .button-container {
                display: none;
            }
        }
    </style>
</head>

<div class="laporan-container">
    <div class="laporan-header">
        <h1>📈 Laporan Pengundian Lengkap</h1>
        <p>Analisis data pengundian untuk semua jawatan</p>
    </div>

    <?php
    // Statistik keseluruhan
    $total_voters = mysqli_fetch_array(mysqli_query($condb, "SELECT COUNT(*) as total FROM pengguna WHERE jenisPengguna='pengundi'"));
    $total_votes = mysqli_fetch_array(mysqli_query($condb, "SELECT COUNT(*) as total FROM undian"));
    $total_candidates = mysqli_fetch_array(mysqli_query($condb, "SELECT COUNT(*) as total FROM calon"));
    $unique_voters = mysqli_fetch_array(mysqli_query($condb, "SELECT COUNT(DISTINCT noKP) as total FROM undian"));

    echo "<div class='stats-grid'>";
    echo "<div class='stat-card'>";
    echo "<div class='stat-label'>Total Pengundi Terdaftar</div>";
    echo "<div class='stat-value'>" . $total_voters['total'] . "</div>";
    echo "</div>";

    echo "<div class='stat-card'>";
    echo "<div class='stat-label'>Pengundi Aktif</div>";
    echo "<div class='stat-value'>" . $unique_voters['total'] . "</div>";
    echo "</div>";

    echo "<div class='stat-card'>";
    echo "<div class='stat-label'>Total vote Diberikan</div>";
    echo "<div class='stat-value'>" . $total_votes['total'] . "</div>";
    echo "</div>";

    $participation_rate = $total_voters['total'] > 0 ? round(($unique_voters['total'] / $total_voters['total']) * 100, 1) : 0;
    echo "<div class='stat-card'>";
    echo "<div class='stat-label'>Kadar Penyertaan</div>";
    echo "<div class='stat-value'>" . $participation_rate . "%</div>";
    echo "</div>";
    echo "</div>";

    // Detail hasil untuk setiap jawatan
    echo "<div class='results-section'>";
    echo "<div class='results-title'>📊 Keputusan Terperinci Mengikut Jawatan</div>";

    $jawatan_query = "SELECT * FROM jawatan ORDER BY kodJawatan";
    $jawatan_result = mysqli_query($condb, $jawatan_query);

    while ($jawatan = mysqli_fetch_array($jawatan_result)) {
        $kodJawatan = $jawatan['kodJawatan'];
        $namaJawatan = $jawatan['namaJawatan'];

        echo "<div class='jawatan-section'>";
        echo "<div class='jawatan-title'>" . htmlspecialchars($namaJawatan) . "</div>";

        // Ambil hasil vote untuk jawatan ini
        $hasil_query = "SELECT calon.noCalon, calon.namaCalon, calon.gambar, COUNT(undian.noCalon) as jumlah_vote
                       FROM calon
                       LEFT JOIN undian ON calon.noCalon = undian.noCalon
                       WHERE calon.kodJawatan = '$kodJawatan'
                       GROUP BY calon.noCalon
                       ORDER BY jumlah_vote DESC";
        $hasil_result = mysqli_query($condb, $hasil_query);

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

            // Tampilkan hasil dengan bar chart
            $position = 1;
            foreach ($temp_data as $hasil) {
                $percentage = $max_votes > 0 ? ($hasil['jumlah_vote'] / $max_votes) * 100 : 0;
                $medal = $position === 1 ? '🥇' : ($position === 2 ? '🥈' : ($position === 3 ? '🥉' : ''));

                echo "<div class='candidate-result'>";
                echo "<div class='candidate-info'>";
                echo "<img src='gambar/" . htmlspecialchars($hasil['gambar']) . "' alt='" . htmlspecialchars($hasil['namaCalon']) . "' class='candidate-image'>";
                echo "<div>";
                echo "<div class='candidate-name'>$medal " . htmlspecialchars($hasil['namaCalon']) . "</div>";
                echo "</div>";
                echo "</div>";

                echo "<div class='votes-bar-container'>";
                echo "<div class='votes-bar' style='width: " . $percentage . "%;'>" . ($percentage > 10 ? round($percentage, 1) . '%' : '') . "</div>";
                echo "</div>";

                echo "<div class='votes-count'>" . $hasil['jumlah_vote'] . " vote</div>";
                echo "</div>";

                $position++;
            }
        } else {
            echo "<div class='no-data'>Tiada data pengundian untuk jawatan ini</div>";
        }

        echo "</div>";
    }

    echo "</div>";
    ?>

    <div class="button-container">
        <a href="index.php" class="btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn-print">🖨️ Cetak Laporan</button>
    </div>
</div>

<?php include('footer.php'); ?>