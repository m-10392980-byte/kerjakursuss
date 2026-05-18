<?php
session_start();
include('header.php');

// Load manifesto data for candidate names
$json = file_get_contents('manifesto-data.json');
$candidates = json_decode($json, true);

// Count votes from files
$votes = array();
$votes_dir = 'votes/';

if (is_dir($votes_dir)) {
    $files = scandir($votes_dir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $data = json_decode(file_get_contents($votes_dir . $file), true);
            if (isset($data['calon_id'])) {
                if (!isset($votes[$data['calon_id']])) {
                    $votes[$data['calon_id']] = 0;
                }
                $votes[$data['calon_id']]++;
            }
        }
    }
}

// Calculate total votes
$total_votes = array_sum($votes);

// Create results array
$results = array();
foreach ($candidates as $candidate) {
    $vote_count = isset($votes[$candidate['id']]) ? $votes[$candidate['id']] : 0;
    $percentage = $total_votes > 0 ? ($vote_count / $total_votes) * 100 : 0;
    
    $results[] = array(
        'id' => $candidate['id'],
        'nama' => $candidate['nama'],
        'jawatan' => $candidate['jawatan'],
        'gambar' => $candidate['gambar'],
        'votes' => $vote_count,
        'percentage' => $percentage
    );
}

// Sort by votes descending
usort($results, function($a, $b) {
    return $b['votes'] - $a['votes'];
});
?>

<section class="results-container">
    <!-- HEADER -->
    <div class="results-header">
        <h2 class="results-title">Keputusan Pengundian</h2>
        <p class="results-subtitle">Hasil Separa-Sementara Pengundian AJK AJK Kadet Polis</p>
    </div>

    <!-- STATS OVERVIEW -->
    <div class="stats-overview">
        <div class="stat-box">
            <div class="stat-icon">📊</div>
            <div class="stat-value"><?php echo $total_votes; ?></div>
            <div class="stat-label">Jumlah Undi</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon">👥</div>
            <div class="stat-value"><?php echo count($candidates); ?></div>
            <div class="stat-label">Calon</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon">✓</div>
            <div class="stat-value"><?php echo count($results); ?></div>
            <div class="stat-label">Jawatan</div>
        </div>
    </div>

    <!-- RESULTS BY POSITION -->
    <?php
    $positions = array('Pengerusi', 'Timbalan Pengerusi', 'Setiausaha', 'Bendahari');
    foreach ($positions as $position):
        $position_results = array_filter($results, function($r) use ($position) {
            return $r['jawatan'] === $position;
        });
        
        if (empty($position_results)) continue;
    ?>
    
    <div class="position-section">
        <h3 class="position-title">📌 <?php echo $position; ?></h3>
        
        <div class="results-grid">
            <?php $rank = 1; foreach ($position_results as $result): ?>
            
            <div class="result-card rank-<?php echo $rank; ?>">
                <div class="result-rank">
                    <?php if ($rank == 1): ?>
                        <span class="rank-badge">🥇 #1</span>
                    <?php elseif ($rank == 2): ?>
                        <span class="rank-badge">🥈 #2</span>
                    <?php else: ?>
                        <span class="rank-badge">🥉 #<?php echo $rank; ?></span>
                    <?php endif; ?>
                </div>

                <div class="result-image">
                    <img src="gambar/<?php echo htmlspecialchars($result['gambar']); ?>" 
                         alt="<?php echo htmlspecialchars($result['nama']); ?>">
                </div>

                <div class="result-info">
                    <h4 class="result-nama"><?php echo htmlspecialchars($result['nama']); ?></h4>
                    <p class="result-jawatan"><?php echo htmlspecialchars($result['jawatan']); ?></p>
                </div>

                <div class="result-votes">
                    <div class="vote-count">
                        <span class="vote-number"><?php echo $result['votes']; ?></span>
                        <span class="vote-label">Undi</span>
                    </div>
                    <div class="vote-percentage">
                        <?php echo number_format($result['percentage'], 1); ?>%
                    </div>
                </div>

                <div class="vote-bar">
                    <div class="bar-fill" style="width: <?php echo $result['percentage']; ?>%;"></div>
                </div>
            </div>

            <?php $rank++; endforeach; ?>
        </div>
    </div>

    <?php endforeach; ?>

    <!-- EMPTY STATE -->
    <?php if ($total_votes == 0): ?>
    <div class="empty-state">
        <div class="empty-icon">📭</div>
        <h3>Belum Ada Undi</h3>
        <p>Pengundian belum bermula atau tiada undi telah disertakan lagi.</p>
    </div>
    <?php endif; ?>

    <!-- ACTION BUTTONS -->
    <div class="results-actions">
        <a href="undi-calon.php" class="btn-back">← Kembali Ke Pengundian</a>
        <a href="manifesto.php" class="btn-manifest">Lihat Manifesto</a>
    </div>
</section>

<?php include('footer.php'); ?>
    </div>
</main>

<style>
/* ============ RESULTS SECTION ============ */
.results-container {
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
}

.results-header {
    text-align: center;
    margin-bottom: 40px;
}

.results-title {
    font-size: 42px;
    font-weight: 900;
    background: linear-gradient(135deg, #10b981, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
}

.results-subtitle {
    font-size: 16px;
    color: #cbd5e1;
}

/* STATS OVERVIEW */
.stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 50px;
}

.stat-box {
    background: var(--glass);
    backdrop-filter: blur(10px) saturate(180%);
    border: 1px solid rgba(16, 185, 129, 0.3);
    border-radius: 18px;
    padding: 28px 24px;
    text-align: center;
    transition: var(--transition);
}

.stat-box:hover {
    transform: translateY(-6px);
    border-color: #10b981;
    box-shadow: 0 12px 28px rgba(16, 185, 129, 0.2);
}

.stat-icon {
    font-size: 40px;
    margin-bottom: 12px;
}

.stat-value {
    font-size: 36px;
    font-weight: 900;
    background: linear-gradient(135deg, #10b981, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
}

.stat-label {
    font-size: 14px;
    color: #cbd5e1;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* POSITION SECTION */
.position-section {
    margin-bottom: 50px;
}

.position-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--text-light);
    margin-bottom: 24px;
    padding-bottom: 12px;
    border-bottom: 2px solid rgba(124, 58, 237, 0.2);
}

/* RESULTS GRID */
.results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
}

.result-card {
    background: var(--glass);
    backdrop-filter: blur(10px) saturate(180%);
    border: 1px solid rgba(124, 58, 237, 0.2);
    border-radius: 18px;
    padding: 24px;
    transition: var(--transition);
    overflow: hidden;
    position: relative;
}

.result-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #10b981, #06b6d4);
}

.result-card.rank-1 {
    border-color: rgba(251, 191, 36, 0.5);
    background: linear-gradient(135deg, rgba(251, 191, 36, 0.05), rgba(124, 58, 237, 0.05));
}

.result-card.rank-1::before {
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
}

.result-card:hover {
    transform: translateY(-8px);
    border-color: #10b981;
    box-shadow: 0 16px 40px rgba(16, 185, 129, 0.2);
}

.result-rank {
    text-align: center;
    margin-bottom: 16px;
}

.rank-badge {
    display: inline-block;
    padding: 8px 14px;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #000;
    border-radius: 20px;
    font-weight: 700;
    font-size: 14px;
}

/* RESULT IMAGE */
.result-image {
    width: 100%;
    height: 200px;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 16px;
    border: 2px solid rgba(124, 58, 237, 0.2);
}

.result-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* RESULT INFO */
.result-info {
    margin-bottom: 16px;
}

.result-nama {
    font-size: 18px;
    font-weight: 800;
    background: linear-gradient(135deg, #10b981, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 6px 0;
}

.result-jawatan {
    font-size: 13px;
    color: #cbd5e1;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
    font-weight: 600;
}

/* RESULT VOTES */
.result-votes {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    background: rgba(16, 185, 129, 0.1);
    border-radius: 10px;
    margin-bottom: 16px;
}

.vote-count {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.vote-number {
    font-size: 28px;
    font-weight: 900;
    color: #10b981;
}

.vote-label {
    font-size: 11px;
    color: #cbd5e1;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.vote-percentage {
    font-size: 24px;
    font-weight: 900;
    color: #10b981;
}

/* VOTE BAR */
.vote-bar {
    height: 8px;
    background: rgba(124, 58, 237, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #10b981, #06b6d4);
    border-radius: 4px;
    transition: width 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 60px 40px;
    background: var(--glass);
    border: 2px dashed rgba(124, 58, 237, 0.2);
    border-radius: 18px;
    margin-bottom: 40px;
}

.empty-icon {
    font-size: 60px;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 24px;
    color: var(--text-light);
    margin: 0 0 12px 0;
}

.empty-state p {
    color: #cbd5e1;
    font-size: 16px;
    margin: 0;
}

/* ACTION BUTTONS */
.results-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    margin-top: 50px;
    flex-wrap: wrap;
}

.btn-back,
.btn-manifest {
    padding: 14px 32px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-back {
    background: var(--glass);
    border: 1.5px solid rgba(124, 58, 237, 0.3);
    color: var(--text-light);
}

.btn-back:hover {
    border-color: #7c3aed;
    background: rgba(124, 58, 237, 0.1);
}

.btn-manifest {
    background: linear-gradient(135deg, #10b981, #06b6d4);
    color: white;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
}

.btn-manifest:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(16, 185, 129, 0.4);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .results-title {
        font-size: 32px;
    }

    .stats-overview {
        grid-template-columns: 1fr;
    }

    .results-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .position-title {
        font-size: 20px;
    }

    .result-card {
        padding: 18px;
    }

    .results-actions {
        flex-direction: column;
    }

    .btn-back,
    .btn-manifest {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .results-title {
        font-size: 26px;
    }

    .result-image {
        height: 160px;
    }

    .result-nama {
        font-size: 16px;
    }

    .vote-number {
        font-size: 22px;
    }

    .vote-percentage {
        font-size: 20px;
    }
}
</style>
</body>
</html>