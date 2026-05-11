 url=https://github.com/m-10392980-byte/te
<?php
session_start();
include('connection.php');

// Semak login
if (!isset($_SESSION['noKP'])) {
    header("location:login.php");
    exit;
}

$noKP = $_SESSION['noKP'];

// Semak pengguna sudah mengundi atau tidak
$semak_undi = mysqli_query($condb, "SELECT * FROM undian WHERE noKP='$noKP'");
if (mysqli_num_rows($semak_undi) > 0) {
    echo "<script>
        alert('Anda sudah mengundi sebelum ini. Anda hanya dibenarkan mengundi sekali.');
        window.location.href='undi-calon.php';
    </script>";
    exit;
}

// Validasi input POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $votes = [];

    // Ambil semua jawatan
    $jawatan_query = "SELECT * FROM jawatan ORDER BY kodJawatan";
    $jawatan_result = mysqli_query($condb, $jawatan_query);

    while ($jawatan = mysqli_fetch_array($jawatan_result)) {
        $kodJawatan = $jawatan['kodJawatan'];
        $field_name = 'jawatan_' . $kodJawatan;

        if (isset($_POST[$field_name]) && !empty($_POST[$field_name])) {
            $noCalon = intval($_POST[$field_name]);
            
            // Validasi calon wujud dan sesuai dengan jawatan
            $calon_check = mysqli_query($condb, "SELECT * FROM calon WHERE noCalon='$noCalon' AND kodJawatan='$kodJawatan'");
            if (mysqli_num_rows($calon_check) > 0) {
                $votes[$noCalon] = $noCalon;
            } else {
                $errors[] = "Pilihan untuk jawatan tidak sah.";
            }
        } else {
            $errors[] = "Sila pilih calon untuk semua jawatan.";
        }
    }

    // Jika tiada error, simpan ke database
    if (count($errors) === 0 && count($votes) > 0) {
        $success = true;
        foreach ($votes as $noCalon) {
            $insert = mysqli_query($condb, "INSERT INTO undian (noKP, noCalon) VALUES ('$noKP', '$noCalon')");
            if (!$insert) {
                $success = false;
                break;
            }
        }

        if ($success) {
            echo "<script>
                alert('✓ Pengundian anda berjaya disimpan. Terima kasih!');
                window.location.href='hasil-undi.php';
            </script>";
            exit;
        } else {
            echo "<script>
                alert('❌ Ralat: Gagal menyimpan pengundian. Sila cuba lagi.');
                window.location.href='undi-calon.php';
            </script>";
            exit;
        }
    } else {
        // Jika ada error
        $error_msg = implode("\\n", $errors);
        echo "<script>
            alert('❌ Ralat:\\n$error_msg');
            window.location.href='undi-calon.php';
        </script>";
        exit;
    }
} else {
    // Akses langsung tanpa POST
    header("location:undi-calon.php");
    exit;
}
?>