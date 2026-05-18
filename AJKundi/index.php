<?php
session_start();
include('header.php');
include('logo.php');
?>

<section class="home-section">
    <h3 class="home-section-title">Senarai Jawatan AJK</h3>
    <div class="jawatan-grid">
        <div class="jawatan-card">
            <div class="jawatan-title">👑 Pengerusi</div>
            <div class="jawatan-desc">Pimpin hala tuju & kebajikan kampung.</div>
        </div>
        <div class="jawatan-card">
            <div class="jawatan-title">🤝 Timbalan Pengerusi</div>
            <div class="jawatan-desc">Bantu operasi & koordinasi program.</div>
        </div>
        <div class="jawatan-card">
            <div class="jawatan-title">📋 Setiausaha</div>
            <div class="jawatan-desc">Urus dokumentasi & mesyuarat.</div>
        </div>
        <div class="jawatan-card">
            <div class="jawatan-title">💰 Bendahari</div>
            <div class="jawatan-desc">Urus kewangan & rekod perbelanjaan.</div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
    </div>
</main>

<script>
    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    // Close sidebar when clicking on nav items
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });
    });
</script>
</body>
</html>