<?php
session_start();
include('connection.php');
include('kawalan-admin.php');

// Semak login admin
if (!isset($_SESSION['noKP']) || $_SESSION['jenisPengguna'] !== 'admin') {
    header("location:login.php");
    exit;
}

// Baca data manifesto
$manifesto_file = 'manifesto-data.json';
if (!file_exists($manifesto_file)) {
    die("❌ Fail manifesto-data.json tidak ditemui!");
}

$manifesto_data = json_decode(file_get_contents($manifesto_file), true);

// Proses import calon
if (isset($_GET['action']) && $_GET['action'] == 'import') {
    $success = 0;
    $fail = 0;
    $errors = [];
    
    // Padam calon lama (jika nak clear)
    // mysqli_query($condb, "TRUNCATE TABLE calon");
    
    foreach ($manifesto_data as $calon) {
        $nama = mysqli_real_escape_string($condb, $calon['nama']);
        $jawatan = mysqli_real_escape_string($condb, $calon['jawatan']);
        $gambar = mysqli_real_escape_string($condb, $calon['gambar']);
        
        // Cari kodJawatan
        $query_jawatan = "SELECT kodJawatan FROM jawatan WHERE namaJawatan = '$jawatan' LIMIT 1";
        $result_jawatan = mysqli_query($condb, $query_jawatan);
        
        if (mysqli_num_rows($result_jawatan) > 0) {
            $row_jawatan = mysqli_fetch_array($result_jawatan);
            $kodJawatan = $row_jawatan['kodJawatan'];
            
            // Insert calon
            $query_calon = "INSERT INTO calon (namaCalon, kodJawatan, gambar, tarikhDaftar, status) 
                           VALUES ('$nama', $kodJawatan, '$gambar', NOW(), 'aktif')";
            
            if (mysqli_query($condb, $query_calon)) {
                $success++;
            } else {
                $fail++;
                $errors[] = "❌ " . $nama . " - " . mysqli_error($condb);
            }
        } else {
            $fail++;
            $errors[] = "❌ " . $nama . " - Jawatan '$jawatan' tidak ditemui";
        }
    }
    
    echo "<script>
        alert('✅ Import Selesai!\\n\\nBerjaya: $success\\nGagal: $fail');
        window.location.href='calon-senarai.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import Calon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            color: #7c3aed;
            text-align: center;
        }
        .calon-list {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            max-height: 300px;
            overflow-y: auto;
        }
        .calon-item {
            padding: 10px;
            margin: 5px 0;
            background: white;
            border-left: 4px solid #06b6d4;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .calon-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .calon-info {
            flex: 1;
        }
        .calon-nama {
            font-weight: bold;
            color: #333;
        }
        .calon-jawatan {
            font-size: 12px;
            color: #666;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-import {
            background: #10b981;
            color: white;
        }
        .btn-import:hover {
            background: #059669;
        }
        .btn-back {
            background: #999;
            color: white;
        }
        .btn-back:hover {
            background: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📥 Import Calon Dari Manifesto</h1>
        
        <p>Calon yang akan diimport:</p>
        <div class="calon-list">
            <?php foreach ($manifesto_data as $calon): ?>
                <div class="calon-item">
                    <img src="gambar/<?php echo htmlspecialchars($calon['gambar']); ?>" alt="<?php echo htmlspecialchars($calon['nama']); ?>" onerror="this.src='gambar/default.png'">
                    <div class="calon-info">
                        <div class="calon-nama">✅ <?php echo htmlspecialchars($calon['nama']); ?></div>
                        <div class="calon-jawatan"><?php echo htmlspecialchars($calon['jawatan']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <p><strong>📊 Jumlah Calon:</strong> <?php echo count($manifesto_data); ?> orang</p>

        <div class="button-group">
            <button class="btn-import" onclick="if(confirm('Anda pasti? Ini akan import <?php echo count($manifesto_data); ?> calon ke database!')) window.location.href='?action=import'">📥 Import Calon Sekarang</button>
            <button class="btn-back" onclick="window.location.href='calon-senarai.php'">← Kembali</button>
        </div>
    </div>
</body>
</html>