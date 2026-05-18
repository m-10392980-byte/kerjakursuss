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
        .senarai-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .senarai-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .senarai-header h1 {
            color: #7c3aed;
            font-size: 28px;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-box {
            display: flex;
            gap: 10px;
            flex: 1;
            min-width: 250px;
        }

        .search-box input {
            flex: 1;
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .search-box button {
            padding: 10px 20px;
            background: #7c3aed;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .search-box button:hover {
            background: #6d28d9;
            transform: translateY(-2px);
        }

        .btn-primary {
            padding: 10px 20px;
            background: linear-gradient(135deg, #7c3aed, #06b6d4);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3);
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .calon-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .calon-table thead {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border-bottom: 2px solid rgba(124, 58, 237, 0.3);
        }

        .calon-table th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #7c3aed;
            white-space: nowrap;
        }

        .calon-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .calon-table tbody tr:hover {
            background: rgba(124, 58, 237, 0.05);
        }

        .calon-table td {
            padding: 16px;
        }

        .calon-gambar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #7c3aed;
        }

        .calon-nama {
            font-weight: 600;
            color: #333;
        }

        .calon-jawatan {
            color: #666;
            font-size: 13px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-view, .btn-edit, .btn-delete {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-view {
            background: #10b981;
            color: white;
        }

        .btn-view:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .btn-edit {
            background: #3b82f6;
            color: white;
        }

        .btn-edit:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            color: #999;
        }

        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #666;
        }

        .error-box {
            background: #fee2e2;
            border: 2px solid #fecaca;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .stats-box {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border: 2px solid rgba(124, 58, 237, 0.2);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #7c3aed;
        }

        @media (max-width: 768px) {
            .senarai-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-box {
                flex-direction: column;
            }

            .header-actions {
                width: 100%;
            }

            .calon-table {
                font-size: 12px;
            }

            .calon-table th, .calon-table td {
                padding: 10px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-view, .btn-edit, .btn-delete {
                width: 100%;
            }
        }
    </style>
</head>

<div class="senarai-container">
    <div class="senarai-header">
        <h1>📋 Senarai Calon</h1>
        <div class="header-actions">
            <a href="calon-daftar-borang.php" class="btn-primary">+ Tambah Calon Baru</a>
        </div>
    </div>

    <?php
    // Statistik Calon
    $query_total = "SELECT COUNT(*) as total FROM calon";
    $result_total = mysqli_query($condb, $query_total);
    
    if ($result_total) {
        $total_calon = mysqli_fetch_array($result_total);
        
        echo "<div class='stats-box'>";
        echo "<div class='stat-card'>";
        echo "<div class='stat-label'>Jumlah Calon</div>";
        echo "<div class='stat-value'>" . $total_calon['total'] . "</div>";
        echo "</div>";
        echo "</div>";
    }
    ?>

    <form method="POST" class="search-box" style="margin-bottom: 20px;">
        <input type="text" name="carian" placeholder="Cari nama calon..." value="<?php echo isset($_POST['carian']) ? htmlspecialchars($_POST['carian']) : ''; ?>">
        <button type="submit">🔍 Cari</button>
        <?php if (isset($_POST['carian']) && !empty($_POST['carian'])): ?>
            <a href="calon-senarai.php" style="padding: 10px 20px; background: #999; color: white; border-radius: 8px; text-decoration: none; display: flex; align-items: center;">Reset</a>
        <?php endif; ?>
    </form>

    <div class="table-responsive">
        <table class="calon-table">
            <thead>
                <tr>
                    <th style="width: 10%;">Gambar</th>
                    <th style="width: 20%;">Nama Calon</th>
                    <th style="width: 20%;">Jawatan</th>
                    <th style="width: 20%;">Tarikh Daftar</th>
                    <th style="width: 30%;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Carian
                $carian = '';
                if (isset($_POST['carian']) && !empty($_POST['carian'])) {
                    $search_term = mysqli_real_escape_string($condb, $_POST['carian']);
                    $carian = " WHERE namaCalon LIKE '%$search_term%'";
                }

                $query = "SELECT c.*, j.namaJawatan FROM calon c 
                          LEFT JOIN jawatan j ON c.kodJawatan = j.kodJawatan 
                          $carian ORDER BY c.tarikhDaftar DESC";
                
                $result = mysqli_query($condb, $query);

                // Pengesahan ralat query
                if (!$result) {
                    echo "<tr><td colspan='5'>";
                    echo "<div class='error-box'>";
                    echo "<strong>⚠️ Ralat Pangkalan Data:</strong><br>";
                    echo "Fail: " . htmlspecialchars(mysqli_error($condb));
                    echo "</div>";
                    echo "</td></tr>";
                } elseif (mysqli_num_rows($result) > 0) {
                    while ($calon = mysqli_fetch_array($result)) {
                        $gambar = !empty($calon['gambar']) ? 'gambar/' . htmlspecialchars($calon['gambar']) : 'gambar/default.png';
                        $tarikh = !empty($calon['tarikhDaftar']) ? date('d/m/Y H:i', strtotime($calon['tarikhDaftar'])) : '-';
                        $jawatan = !empty($calon['namaJawatan']) ? htmlspecialchars($calon['namaJawatan']) : 'Tidak Diketahui';

                        echo "<tr>";
                        echo "<td><img src='" . $gambar . "' alt='Gambar' class='calon-gambar' onerror=\"this.src='gambar/default.png'\"></td>";
                        echo "<td><div class='calon-nama'>" . htmlspecialchars($calon['namaCalon']) . "</div></td>";
                        echo "<td><div class='calon-jawatan'>" . $jawatan . "</div></td>";
                        echo "<td>" . $tarikh . "</td>";
                        echo "<td>";
                        echo "<div class='action-buttons'>";
                        echo "<a href='calon-lihat.php?idCalon=" . urlencode($calon['idCalon']) . "' class='btn-view'>👁️ Lihat</a>";
                        echo "<a href='calon-kemaskini-borang.php?idCalon=" . urlencode($calon['idCalon']) . "' class='btn-edit'>✏️ Edit</a>";
                        echo "<a href='calon-padam.php?idCalon=" . urlencode($calon['idCalon']) . "' class='btn-delete' onclick=\"return confirm('Anda pasti ingin memadam calon ini?')\">🗑️ Padam</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td colspan='5'>";
                    echo "<div class='empty-state'>";
                    echo "<h3>📭 Tiada Data Calon</h3>";
                    echo "<p>Sila tambah calon baru untuk memulakan</p>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('footer.php'); ?>
