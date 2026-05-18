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

        .pengguna-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .pengguna-table thead {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border-bottom: 2px solid rgba(124, 58, 237, 0.3);
        }

        .pengguna-table th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #7c3aed;
            white-space: nowrap;
        }

        .pengguna-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .pengguna-table tbody tr:hover {
            background: rgba(124, 58, 237, 0.05);
        }

        .pengguna-table td {
            padding: 16px;
        }

        .pengguna-nama {
            font-weight: 600;
            color: #333;
        }

        .pengguna-nokp {
            color: #666;
            font-family: monospace;
            font-size: 12px;
        }

        .jenis-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .jenis-admin {
            background: #fecaca;
            color: #991b1b;
        }

        .jenis-pengundi {
            background: #bfdbfe;
            color: #1e40af;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-edit, .btn-delete {
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

            .pengguna-table {
                font-size: 12px;
            }

            .pengguna-table th, .pengguna-table td {
                padding: 10px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-edit, .btn-delete {
                width: 100%;
            }
        }
    </style>
</head>

<div class="senarai-container">
    <div class="senarai-header">
        <h1>👥 Senarai Pengguna</h1>
        <div class="header-actions">
            <a href="pengguna-upload.php" class="btn-primary">+ Muat Naik Data Pengguna</a>
        </div>
    </div>

    <?php
    // Statistik
    $total_pengguna = mysqli_fetch_array(mysqli_query($condb, "SELECT COUNT(*) as total FROM pengguna"));
    $total_admin = mysqli_fetch_array(mysqli_query($condb, "SELECT COUNT(*) as total FROM pengguna WHERE jenisPengguna='admin'"));
    $total_pengundi = mysqli_fetch_array(mysqli_query($condb, "SELECT COUNT(*) as total FROM pengguna WHERE jenisPengguna='pengundi'"));
    
    echo "<div class='stats-box'>";
    echo "<div class='stat-card'>";
    echo "<div class='stat-label'>Total Pengguna</div>";
    echo "<div class='stat-value'>" . $total_pengguna['total'] . "</div>";
    echo "</div>";

    echo "<div class='stat-card'>";
    echo "<div class='stat-label'>Admin</div>";
    echo "<div class='stat-value'>" . $total_admin['total'] . "</div>";
    echo "</div>";

    echo "<div class='stat-card'>";
    echo "<div class='stat-label'>Pengundi</div>";
    echo "<div class='stat-value'>" . $total_pengundi['total'] . "</div>";
    echo "</div>";
    echo "</div>";
    ?>

    <form method="POST" class="search-box" style="margin-bottom: 20px;">
        <input type="text" name="carian" placeholder="Cari nama atau No. KP..." value="<?php echo isset($_POST['carian']) ? htmlspecialchars($_POST['carian']) : ''; ?>">
        <button type="submit">🔍 Cari</button>
        <?php if (isset($_POST['carian']) && !empty($_POST['carian'])): ?>
            <a href="?reset=1" style="padding: 10px 20px; background: #999; color: white; border-radius: 8px; text-decoration: none; display: flex; align-items: center;">Reset</a>
        <?php endif; ?>
    </form>

    <div class="table-responsive">
        <table class="pengguna-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Nama Pengguna</th>
                    <th style="width: 20%;">No. Kad Pengenalan</th>
                    <th style="width: 20%;">Jenis Pengguna</th>
                    <th style="width: 25%;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Carian
                $carian = '';
                if (isset($_POST['carian']) && !empty($_POST['carian'])) {
                    $search_term = mysqli_real_escape_string($condb, $_POST['carian']);
                    $carian = " WHERE pengguna.nama LIKE '%$search_term%' OR pengguna.noKP LIKE '%$search_term%'";
                }

                $query = "SELECT * FROM pengguna $carian ORDER BY jenisPengguna DESC, nama";
                $result = mysqli_query($condb, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($pengguna = mysqli_fetch_array($result)) {
                        $jenis_class = $pengguna['jenisPengguna'] === 'admin' ? 'jenis-admin' : 'jenis-pengundi';
                        $jenis_text = $pengguna['jenisPengguna'] === 'admin' ? '👨‍💼 Admin' : '🗳️ Pengundi';

                        echo "<tr>";
                        echo "<td>";
                        echo "<div class='pengguna-nama'>" . htmlspecialchars($pengguna['nama']) . "</div>";
                        echo "</td>";
                        echo "<td>";
                        echo "<div class='pengguna-nokp'>" . htmlspecialchars($pengguna['noKP']) . "</div>";
                        echo "</td>";
                        echo "<td>";
                        echo "<span class='jenis-badge $jenis_class'>$jenis_text</span>";
                        echo "</td>";
                        echo "<td>";
                        echo "<div class='action-buttons'>";
                        echo "<a href='pengguna-kemaskini-borang.php?noKP=" . urlencode($pengguna['noKP']) . "' class='btn-edit'>✏️ Edit</a>";
                        echo "<a href='pengguna-padam.php?noKP=" . urlencode($pengguna['noKP']) . "' class='btn-delete' onclick=\"return confirm('Anda pasti ingin memadam pengguna ini?')\">🗑️ Hapus</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td colspan='4'>";
                    echo "<div class='empty-state'>";
                    echo "<h3>Tiada Data Pengguna</h3>";
                    echo "<p>Sila muat naik data pengguna terlebih dahulu</p>";
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