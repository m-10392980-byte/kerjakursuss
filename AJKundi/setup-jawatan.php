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

// Ambil jawatan unik dari manifesto
$jawatan_list = [];
foreach ($manifesto_data as $calon) {
    if (!in_array($calon['jawatan'], $jawatan_list)) {
        $jawatan_list[] = $calon['jawatan'];
    }
}

// Proses setup jawatan
if (isset($_GET['action']) && $_GET['action'] == 'setup') {
    // Padam jadual jawatan lama
    mysqli_query($condb, "TRUNCATE TABLE jawatan");
    
    // Insert jawatan baru
    $success = 0;
    $fail = 0;
    
    foreach ($jawatan_list as $jawatan) {
        $query = "INSERT INTO jawatan (namaJawatan, penerangan) VALUES ('$jawatan', '')";
        if (mysqli_query($condb, $query)) {
            $success++;
        } else {
            $fail++;
        }
    }
    
    echo "<script>
        alert('✅ Setup Selesai!\\n\\nBerjaya: $success\\nGagal: $fail');
        window.location.href='calon-senarai.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Setup Jawatan</title>
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
        .jawatan-list {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .jawatan-item {
            padding: 10px;
            margin: 5px 0;
            background: white;
            border-left: 4px solid #7c3aed;
            border-radius: 4px;
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
        .btn-setup {
            background: #7c3aed;
            color: white;
        }
        .btn-setup:hover {
            background: #6d28d9;
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
        <h1>⚙️ Setup Jawatan Dari Manifesto</h1>
        
        <p>Jawatan yang akan disetup:</p>
        <div class="jawatan-list">
            <?php foreach ($jawatan_list as $jawatan): ?>
                <div class="jawatan-item">✅ <?php echo htmlspecialchars($jawatan); ?></div>
            <?php endforeach; ?>
        </div>

        <p><strong>⚠️ Amaran:</strong> Ini akan <strong>PADAM SEMUA JAWATAN LAMA</strong> dan ganti dengan jawatan baru dari manifesto.</p>

        <div class="button-group">
            <button class="btn-setup" onclick="if(confirm('Anda pasti? Ini akan padam semua jawatan lama!')) window.location.href='?action=setup'">🔧 Setup Jawatan Sekarang</button>
            <button class="btn-back" onclick="window.location.href='calon-senarai.php'">← Kembali</button>
        </div>
    </div>
</body>
</html>