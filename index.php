<?php
require_once 'config.php';
require_once 'includes/functions.php';

$page_title = "KriptoHunter - Yapay Zeka Destekli Profesyonel Piyasa Analizi";
$page_description = "Yapay zeka destekli profesyonel piyasa analizi. Hisse senetleri, kripto paralar, fonlar ve emtialar için teknik analiz, AL/SAT sinyalleri ve TradingView grafikleri.";
$page_keywords = "hisse senedi analizi, kripto para analizi, teknik analiz, yapay zeka, borsa, tradingview, bist, altın analizi";

include 'includes/header.php';
?>

<div class="container">
    <!-- Hero Section -->
    <div class="hero-section text-center py-5">
        <h1 class="display-4 fw-bold mb-3">
            <span class="gradient-text">Yapay Zeka</span> ile<br>
            Profesyonel Piyasa Analizi
        </h1>
        <p class="lead text-muted mb-4">Hisse senetleri, kripto paralar, fonlar ve emtialar için AI destekli teknik analiz</p>
        
        <!-- Search Box -->
        <div class="search-box mx-auto" style="max-width: 600px;">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control form-control-lg" 
                       placeholder="Sembol girin (THYAO, BTCUSDT, AAPL, XAUUSD...)"
                       style="background: rgba(15,23,42,0.8); border-color: rgba(56,189,248,0.3); color: white;">
                <button class="btn btn-primary btn-lg" onclick="searchSymbol()">
                    <i class="fas fa-magic"></i> Analiz Et
                </button>
            </div>
            <div class="mt-3">
                <small class="text-muted">Popüler:</small>
                <div class="mt-2">
                    <span class="badge bg-secondary m-1" onclick="searchWithSymbol('THYAO')">THYAO</span>
                    <span class="badge bg-secondary m-1" onclick="searchWithSymbol('BTCUSDT')">BTCUSDT</span>
                    <span class="badge bg-secondary m-1" onclick="searchWithSymbol('AAPL')">AAPL</span>
                    <span class="badge bg-secondary m-1" onclick="searchWithSymbol('XAUUSD')">XAUUSD</span>
                    <span class="badge bg-secondary m-1" onclick="searchWithSymbol('EURUSD')">EURUSD</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kategoriler -->
    <div class="row g-4 mt-4">
        <div class="col-md-4">
            <div class="card-dark p-4 text-center h-100">
                <div class="icon-wrapper mb-3">
                    <i class="fas fa-chart-line fa-3x text-primary"></i>
                </div>
                <h3>Hisse Senetleri</h3>
                <p class="text-muted">Borsa İstanbul hisseleri için AI destekli teknik analiz</p>
                <a href="/hisse-senedi/" class="btn btn-outline-primary">İncele <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-dark p-4 text-center h-100">
                <div class="icon-wrapper mb-3">
                    <i class="fab fa-bitcoin fa-3x text-primary"></i>
                </div>
                <h3>Kripto Paralar</h3>
                <p class="text-muted">Bitcoin, Ethereum ve altcoinler için teknik analiz</p>
                <a href="/kripto/" class="btn btn-outline-primary">İncele <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-dark p-4 text-center h-100">
                <div class="icon-wrapper mb-3">
                    <i class="fas fa-gem fa-3x text-primary"></i>
                </div>
                <h3>Emtia & Forex</h3>
                <p class="text-muted">Altın, gümüş, petrol ve döviz çiftleri analizi</p>
                <a href="/emtia/" class="btn btn-outline-primary">İncele <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <!-- Son Analizler -->
    <div class="mt-5">
        <h2><i class="fas fa-history"></i> Son Analizler</h2>
        <div class="row mt-3">
            <?php
            $latest_analyses = mysqli_query($conn, "SELECT * FROM analyses ORDER BY created_at DESC LIMIT 6");
            if(mysqli_num_rows($latest_analyses) > 0):
                while($analysis = mysqli_fetch_assoc($latest_analyses)):
            ?>
            <div class="col-md-4 mb-3">
                <div class="card-dark p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo htmlspecialchars($analysis['symbol']); ?></h5>
                        <span class="badge <?php echo $analysis['recommendation'] == 'BUY' ? 'bg-success' : ($analysis['recommendation'] == 'SELL' ? 'bg-danger' : 'bg-warning'); ?>">
                            <?php echo $analysis['recommendation']; ?>
                        </span>
                    </div>
                    <small class="text-muted"><?php echo date('d.m.Y H:i', strtotime($analysis['created_at'])); ?></small>
                    <p class="small mt-2 text-muted"><?php echo mb_substr(strip_tags($analysis['analysis_text']), 0, 100); ?>...</p>
                    <a href="/detay/<?php echo $analysis['symbol']; ?>" class="btn btn-sm btn-outline-primary">Detaylı Analiz</a>
                </div>
            </div>
            <?php 
                endwhile;
            else:
            ?>
            <div class="col-12">
                <div class="card-dark p-4 text-center">
                    <p class="text-muted mb-0">Henüz analiz yapılmamış. Yukarıdaki arama kutusundan bir sembol aratın!</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.gradient-text {
    background: linear-gradient(135deg, #38bdf8, #818cf8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.hero-section {
    padding: 60px 0;
}
.icon-wrapper {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(56,189,248,0.1);
    border-radius: 50%;
}
.form-control:focus {
    background: rgba(15,23,42,0.9);
    border-color: #38bdf8;
    box-shadow: 0 0 0 0.2rem rgba(56,189,248,0.25);
}
.badge {
    cursor: pointer;
    transition: all 0.3s;
}
.badge:hover {
    transform: translateY(-2px);
    background: #38bdf8;
}
</style>

<script>
function searchSymbol() {
    const symbol = document.getElementById('searchInput').value.trim().toUpperCase();
    if(symbol) {
        window.location.href = '/search.php?q=' + encodeURIComponent(symbol);
    } else {
        alert('Lütfen bir sembol girin!');
    }
}

function searchWithSymbol(symbol) {
    window.location.href = '/search.php?q=' + encodeURIComponent(symbol);
}

// Enter tuşu
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if(e.key === 'Enter') {
        searchSymbol();
    }
});
</script>

<?php include 'includes/footer.php'; ?>