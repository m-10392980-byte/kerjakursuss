<?php
$tarikh = "2026-10-10 23:59:59"; // tarikh akhir mengundi
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>VOTE4LEADER - Sistem Pengundian</title>
</head>

<body class="<?php echo basename($_SERVER['PHP_SELF'], '.php'); ?>">

<!-- SIDEBAR NAVIGATION -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <div class="logo-icon">🗳️</div>
            <div class="logo-text">VOTE4LEADER</div>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <?php if (!empty($_SESSION['jenisPengguna'])) { ?>
            <!-- ADMIN MENU -->
            <?php if ($_SESSION['jenisPengguna'] == "admin") { ?>
                <a href="index.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i>
                    <span>Laman Utama</span>
                </a>
                <a href="manifesto.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'manifesto.php') ? 'active' : ''; ?>">
                    <i class="fas fa-scroll"></i>
                    <span>Manifesto</span>
                </a>
                <a href="calon-senarai.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'calon-senarai.php') ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i>
                    <span>Senarai Calon</span>
                </a>
                <a href="pengguna-senarai.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'pengguna-upload.php') ? 'active' : ''; ?>">
                    <i class="fas fa-user-group"></i>
                    <span>Senarai Pengguna</span>
                </a>
                <a href="laporan.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'laporan.php') ? 'active' : ''; ?>">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan Undian</span>
                </a>
                <a href="countdown.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'countdown.php') ? 'active' : ''; ?>">
                    <i class="fas fa-hourglass-end"></i>
                    <span>Pengiraan Masa</span>
                </a>
                
            <!-- VOTER MENU -->
            <?php } elseif ($_SESSION['jenisPengguna'] == "pengundi") { ?>
                <a href="index.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i>
                    <span>Laman Utama</span>
                </a>
                <a href="manifesto.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'manifesto.php') ? 'active' : ''; ?>">
                    <i class="fas fa-scroll"></i>
                    <span>Manifesto</span>
                </a>
                <a href="undi-calon.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'undi-calon.php') ? 'active' : ''; ?>">
                    <i class="fas fa-check-circle"></i>
                    <span>Undi Calon</span>
                </a>
                <a href="countdown.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'countdown.php') ? 'active' : ''; ?>">
                    <i class="fas fa-hourglass-end"></i>
                    <span>Pengiraan Masa</span>
                     <a href="hasil-undi.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'hasil-undi.php') ? 'active' : ''; ?>">
    <i class="fas fa-chart-bar"></i>
                    <span>Undian Anda</span>
                </a>
            <?php } ?>

            <div class="sidebar-divider"></div>

            <!-- USER INFO & LOGOUT -->
            <div class="user-section">
                <div class="user-info">
                    <div class="user-avatar">👤</div>
                    <div class="user-details">
                        <div class="user-name"><?php echo htmlspecialchars($_SESSION['jenisPengguna']); ?></div>
                        <div class="user-role">
                            <?php echo ($_SESSION['jenisPengguna'] == 'admin') ? 'Admin' : 'Pengundi'; ?>
                        </div>
                    </div>
                </div>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>

        <?php } else { ?>
            <!-- GUEST MENU -->
            <a href="index.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                <span>Laman Utama</span>
            </a>
            <a href="manifesto.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'manifesto.php') ? 'active' : ''; ?>">
                <i class="fas fa-scroll"></i>
                <span>Manifesto</span>
            </a>
            <a href="countdown.php" class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'countdown.php') ? 'active' : ''; ?>">
                <i class="fas fa-hourglass-end"></i>
                <span>Pengiraan Masa</span>
            </a>

            <div class="sidebar-divider"></div>

            <!-- GUEST AUTH BUTTONS -->
            <div class="auth-section">
                <a href="login.php" class="auth-btn login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Log Masuk</span>
                </a>
                <a href="signup.php" class="auth-btn signup-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar Sini</span>
                </a>
            </div>
        <?php } ?>
    </nav>
</aside>

<!-- MAIN CONTENT AREA -->
<main class="main-content">
    <!-- HEADER TOP BAR -->
    <header class="top-header">
        <div class="header-left">
            <h1 class="tajuk">VOTE4LEADER - Pengundian Pemilihan AJK Kadet Polis</h1>
        </div>
        <div class="header-right">
            <button class="theme-toggle" id="themeToggle" title="Toggle dark/light mode">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </header>

    <!-- PAGE CONTENT CONTAINER -->
    <div class="page-content">