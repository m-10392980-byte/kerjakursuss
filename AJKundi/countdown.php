<?php
session_start();
include("header.php");
$tarikh = "2026-10-10 23:59:59"; // tarikh akhir mengundi
?>

<section class="countdown-container">
    <!-- COUNTDOWN CARD -->
    <div class="countdown-card">
        <div class="countdown-header">
            <i class="fas fa-hourglass-end"></i>
            <h2>Masa Akhir Mengundi</h2>
        </div>

        <!-- COUNTDOWN DISPLAY -->
        <div class="countdown-display">
            <div class="countdown-box">
                <div class="countdown-value" id="days">00</div>
                <div class="countdown-label">Hari</div>
            </div>
            <div class="countdown-separator">:</div>
            <div class="countdown-box">
                <div class="countdown-value" id="hours">00</div>
                <div class="countdown-label">Jam</div>
            </div>
            <div class="countdown-separator">:</div>
            <div class="countdown-box">
                <div class="countdown-value" id="minutes">00</div>
                <div class="countdown-label">Minit</div>
            </div>
            <div class="countdown-separator">:</div>
            <div class="countdown-box">
                <div class="countdown-value" id="seconds">00</div>
                <div class="countdown-label">Saat</div>
            </div>
        </div>

        <!-- DATE & TIME -->
        <div class="countdown-date">
            <p><strong>Target Tarikh:</strong> <?php echo date("d F Y, g:i A", strtotime($tarikh)); ?></p>
        </div>

        <!-- PROGRESS BAR -->
        <div class="countdown-progress">
            <div class="progress-bar" id="progressBar"></div>
        </div>

        <!-- STATUS MESSAGE -->
        <div class="countdown-status" id="countdownStatus">
            <p id="statusText">Pengundian sedang berlangsung...</p>
        </div>
    </div>

    <!-- INFO CARDS -->
    <div class="info-grid">
        <div class="info-card">
            <div class="info-icon">📋</div>
            <h3>Segera Daftar</h3>
            <p>Pastikan anda telah mendaftar sebelum masa akhir</p>
        </div>
        <div class="info-card">
            <div class="info-icon">✓</div>
            <h3>Siapkan Pilihan</h3>
            <p>Sediakan senarai calon pilihan anda</p>
        </div>
        <div class="info-card">
            <div class="info-icon">🎯</div>
            <h3>Undi dengan Bijak</h3>
            <p>Luangkan masa untuk membuat keputusan terbaik</p>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>
    </div>
</main>

<style>
/* ============ COUNTDOWN SECTION ============ */
.countdown-container {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
}

.countdown-card {
    background: linear-gradient(135deg, rgba(124, 58, 237, 0.08) 0%, rgba(6, 182, 212, 0.08) 100%);
    border: 2px solid rgba(124, 58, 237, 0.3);
    border-radius: 24px;
    padding: 50px 40px;
    margin-bottom: 40px;
    box-shadow: 0 12px 40px rgba(124, 58, 237, 0.15);
    position: relative;
    overflow: hidden;
}

.countdown-card::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(124, 58, 237, 0.1) 0%, transparent 70%);
    animation: pulse-bg 15s ease-in-out infinite;
    z-index: 0;
}

@keyframes pulse-bg {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.countdown-header {
    text-align: center;
    margin-bottom: 40px;
    position: relative;
    z-index: 1;
}

.countdown-header i {
    font-size: 48px;
    background: linear-gradient(135deg, #7c3aed, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 16px;
    display: block;
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.countdown-header h2 {
    font-size: 36px;
    font-weight: 900;
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
}

/* COUNTDOWN DISPLAY */
.countdown-display {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    margin-bottom: 30px;
    position: relative;
    z-index: 1;
    flex-wrap: wrap;
}

.countdown-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: var(--glass);
    backdrop-filter: blur(10px) saturate(180%);
    border: 1px solid rgba(124, 58, 237, 0.3);
    border-radius: 16px;
    padding: 20px 24px;
    min-width: 90px;
}

.countdown-value {
    font-size: 48px;
    font-weight: 900;
    background: linear-gradient(135deg, #7c3aed, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-variant-numeric: tabular-nums;
}

.countdown-label {
    font-size: 12px;
    color: #cbd5e1;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 8px;
    font-weight: 600;
}

.countdown-separator {
    font-size: 36px;
    color: #7c3aed;
    font-weight: 900;
    margin: 0 4px;
}

/* DATE & TIME */
.countdown-date {
    text-align: center;
    margin-bottom: 30px;
    position: relative;
    z-index: 1;
    padding: 20px;
    background: rgba(124, 58, 237, 0.1);
    border-radius: 12px;
    border: 1px solid rgba(124, 58, 237, 0.2);
}

.countdown-date p {
    font-size: 16px;
    color: var(--text-light);
    margin: 0;
    font-weight: 600;
}

.countdown-date strong {
    color: #7c3aed;
}

/* PROGRESS BAR */
.countdown-progress {
    height: 6px;
    background: rgba(124, 58, 237, 0.2);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 30px;
    position: relative;
    z-index: 1;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #7c3aed, #06b6d4);
    width: 100%;
    border-radius: 3px;
    transition: width 1s linear;
    box-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
}

/* STATUS MESSAGE */
.countdown-status {
    text-align: center;
    padding: 16px;
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    border-radius: 12px;
    position: relative;
    z-index: 1;
}

.countdown-status p {
    margin: 0;
    color: #10b981;
    font-weight: 600;
    font-size: 16px;
}

.countdown-status.ended {
    background: rgba(239, 68, 68, 0.1);
    border-color: rgba(239, 68, 68, 0.3);
}

.countdown-status.ended p {
    color: #ef4444;
}

/* INFO GRID */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    position: relative;
    z-index: 1;
}

.info-card {
    background: var(--glass);
    backdrop-filter: blur(10px) saturate(180%);
    border: 1px solid rgba(124, 58, 237, 0.2);
    border-radius: 16px;
    padding: 28px 24px;
    text-align: center;
    transition: var(--transition);
}

.info-card:hover {
    transform: translateY(-8px);
    border-color: #7c3aed;
    box-shadow: 0 12px 32px rgba(124, 58, 237, 0.15);
}

.info-icon {
    font-size: 40px;
    margin-bottom: 16px;
    display: block;
}

.info-card h3 {
    font-size: 18px;
    color: var(--text-light);
    margin-bottom: 8px;
    font-weight: 700;
}

.info-card p {
    font-size: 14px;
    color: #cbd5e1;
    line-height: 1.5;
    margin: 0;
}

/* ============ RESPONSIVE ============ */
@media (max-width: 1024px) {
    .countdown-card {
        padding: 40px 30px;
    }

    .countdown-header h2 {
        font-size: 32px;
    }

    .countdown-value {
        font-size: 42px;
    }

    .countdown-separator {
        font-size: 30px;
        margin: 0 2px;
    }

    .countdown-box {
        min-width: 80px;
        padding: 16px 20px;
    }
}

@media (max-width: 768px) {
    .countdown-card {
        padding: 30px 20px;
    }

    .countdown-header h2 {
        font-size: 28px;
    }

    .countdown-display {
        gap: 8px;
    }

    .countdown-value {
        font-size: 36px;
    }

    .countdown-separator {
        font-size: 24px;
        margin: 0;
    }

    .countdown-box {
        min-width: 70px;
        padding: 14px 16px;
        border-radius: 12px;
    }

    .countdown-label {
        font-size: 11px;
        margin-top: 6px;
    }

    .countdown-date p {
        font-size: 14px;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .countdown-card {
        padding: 20px 16px;
        border-radius: 16px;
    }

    .countdown-header i {
        font-size: 36px;
    }

    .countdown-header h2 {
        font-size: 22px;
    }

    .countdown-display {
        gap: 6px;
    }

    .countdown-value {
        font-size: 28px;
    }

    .countdown-separator {
        font-size: 18px;
    }

    .countdown-box {
        min-width: 60px;
        padding: 12px 12px;
    }

    .countdown-label {
        font-size: 10px;
    }

    .countdown-date {
        padding: 14px;
        font-size: 14px;
    }

    .countdown-date p {
        font-size: 13px;
    }
}
</style>

<script>
// Countdown Timer Script
function updateCountdown() {
    const countDownDate = new Date("<?php echo $tarikh; ?>").getTime();
    
    const updateTimer = setInterval(() => {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Update display with leading zeros
        document.getElementById('days').textContent = String(days).padStart(2, '0');
        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');

        // Update progress bar
        const totalTime = countDownDate - new Date("<?php echo date('Y-m-d H:i:s'); ?>").getTime();
        const elapsed = totalTime - distance;
        const progress = (elapsed / totalTime) * 100;
        document.getElementById('progressBar').style.width = Math.max(0, 100 - progress) + '%';

        // Check if countdown ended
        if (distance < 0) {
            clearInterval(updateTimer);
            document.getElementById('days').textContent = '00';
            document.getElementById('hours').textContent = '00';
            document.getElementById('minutes').textContent = '00';
            document.getElementById('seconds').textContent = '00';
            
            const statusEl = document.getElementById('countdownStatus');
            statusEl.classList.add('ended');
            document.getElementById('statusText').innerHTML = '🛑 Masa Mengundi Telah Tamat!';
            document.getElementById('progressBar').style.width = '0%';
        }
    }, 1000);
}

// Start countdown on page load
window.addEventListener('DOMContentLoaded', updateCountdown);
</script>

