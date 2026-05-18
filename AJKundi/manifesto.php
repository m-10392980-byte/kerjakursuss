<?php
session_start();
include('header.php');

// Load manifesto data
$json = file_get_contents('manifesto-data.json');
$manifestos = json_decode($json, true);
?>

<section class="manifesto-container">
    <div class="manifesto-header">
        <h2 class="manifesto-title">Manifesto Calon AJK</h2>
        <p class="manifesto-subtitle">Visi dan Misi Calon untuk AJK Kadet Polis</p>
    </div>

    <!-- FILTER BUTTONS -->
    <div class="filter-section">
        <button class="filter-btn active" onclick="filterJawatan('Semua')">Semua</button>
        <button class="filter-btn" onclick="filterJawatan('Pengerusi')">Pengerusi</button>
        <button class="filter-btn" onclick="filterJawatan('Timbalan Pengerusi')">Timbalan Pengerusi</button>
        <button class="filter-btn" onclick="filterJawatan('Setiausaha')">Setiausaha</button>
        <button class="filter-btn" onclick="filterJawatan('Bendahari')">Bendahari</button>
    </div>

    <!-- MANIFESTO GRID -->
    <div class="manifesto-grid" id="manifestoGrid">
        <?php foreach ($manifestos as $calon): ?>
        <div class="manifesto-card" data-jawatan="<?php echo htmlspecialchars($calon['jawatan']); ?>">
            <!-- Card Top (Image) -->
            <div class="manifesto-image-wrapper">
                <img src="gambar/<?php echo htmlspecialchars($calon['gambar']); ?>" 
                     alt="<?php echo htmlspecialchars($calon['nama']); ?>" 
                     class="manifesto-image">
                <div class="jawatan-badge"><?php echo htmlspecialchars($calon['jawatan']); ?></div>
            </div>

            <!-- Card Content -->
            <div class="manifesto-content">
                <h3 class="manifesto-nama"><?php echo htmlspecialchars($calon['nama']); ?></h3>
                
                <div class="manifesto-body">
                    <p class="manifesto-manifesto">
                        <strong>Manifesto:</strong> <?php echo htmlspecialchars($calon['manifesto']); ?>
                    </p>
                </div>

                <!-- Card Footer -->
                <div class="manifesto-footer">
                    <a href="undi-calon.php?id=<?php echo $calon['id']; ?>" class="undi-btn">
                        <i class="fas fa-vote-yea"></i> Undi Sekarang
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include('footer.php'); ?>
    </div>
</main>

<style>
/* ============ MANIFESTO SECTION ============ */
.manifesto-container {
    width: 100%;
}

.manifesto-header {
    text-align: center;
    margin-bottom: 40px;
}

.manifesto-title {
    font-size: 40px;
    font-weight: 900;
    background: linear-gradient(135deg, #7c3aed, #ec4899, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
}

.manifesto-subtitle {
    font-size: 18px;
    color: #cbd5e1;
}

/* FILTER BUTTONS */
.filter-section {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 12px 24px;
    background: var(--glass);
    border: 1.5px solid rgba(124, 58, 237, 0.3);
    color: var(--text-light);
    border-radius: 20px;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: var(--transition);
}

.filter-btn:hover,
.filter-btn.active {
    background: linear-gradient(135deg, #7c3aed, #06b6d4);
    border-color: transparent;
    color: white;
    box-shadow: 0 8px 16px rgba(124, 58, 237, 0.3);
}

/* MANIFESTO GRID */
.manifesto-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    animation: fadeIn 0.4s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.manifesto-card {
    background: var(--glass);
    backdrop-filter: blur(10px) saturate(180%);
    border: 1px solid rgba(124, 58, 237, 0.2);
    border-radius: 20px;
    overflow: hidden;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
}

.manifesto-card:hover {
    transform: translateY(-12px);
    border-color: #7c3aed;
    box-shadow: 0 20px 40px rgba(124, 58, 237, 0.2);
}

.manifesto-card.hidden {
    display: none;
}

/* IMAGE WRAPPER */
.manifesto-image-wrapper {
    position: relative;
    width: 100%;
    height: 280px;
    overflow: hidden;
    background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(6, 182, 212, 0.1));
}

.manifesto-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.manifesto-card:hover .manifesto-image {
    transform: scale(1.1);
}

.jawatan-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: linear-gradient(135deg, #7c3aed, #06b6d4);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* CARD CONTENT */
.manifesto-content {
    padding: 24px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.manifesto-nama {
    font-size: 22px;
    font-weight: 800;
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 16px 0;
}

.manifesto-body {
    flex: 1;
    margin-bottom: 20px;
}

.manifesto-manifesto {
    font-size: 14px;
    line-height: 1.6;
    color: #cbd5e1;
    margin: 0;
}

.manifesto-manifesto strong {
    color: #7c3aed;
}

/* FOOTER */
.manifesto-footer {
    display: flex;
    gap: 12px;
}

.undi-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px;
    background: linear-gradient(135deg, #7c3aed, #06b6d4);
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.undi-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .manifesto-title {
        font-size: 32px;
    }

    .manifesto-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 18px;
    }

    .manifesto-image-wrapper {
        height: 240px;
    }

    .filter-section {
        gap: 8px;
    }

    .filter-btn {
        padding: 10px 18px;
        font-size: 13px;
    }
}

@media (max-width: 480px) {
    .manifesto-title {
        font-size: 26px;
    }

    .manifesto-grid {
        grid-template-columns: 1fr;
    }

    .manifesto-image-wrapper {
        height: 200px;
    }

    .filter-section {
        flex-direction: column;
    }

    .filter-btn {
        width: 100%;
    }
}
</style>

<script>
function filterJawatan(jawatan) {
    const cards = document.querySelectorAll('.manifesto-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Update active button
    buttons.forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Filter cards
    cards.forEach(card => {
        if (jawatan === 'Semua' || card.dataset.jawatan === jawatan) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
}
</script>
</body>
</html>