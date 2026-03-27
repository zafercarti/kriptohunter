<?php
// 404.php
require_once 'config.php';
require_once 'includes/functions.php';

$searched = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';

$page_title = "Sayfa Bulunamadı - KriptoHunter";
$page_description = "Aradığınız sayfa bulunamadı. Lütfen geçerli bir sembol girin veya ana sayfaya dönün.";

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-404 p-5">
                <div class="mb-4">
                    <i class="fas fa-chart-line fa-4x text-muted"></i>
                </div>
                <h1 class="display-1 fw-bold text-primary">404</h1>
                <h2 class="mb-3">Sayfa Bulunamadı</h2>
                
                <?php if($searched): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-search"></i> "<strong><?php echo $searched; ?></strong>" için sonuç bulunamadı.
                </div>
                <?php endif; ?>
                
                <p class="text-muted mb-4">
                    Aradığınız sembol TradingView'de bulunamadı veya yanlış yazmış olabilirsiniz.
                </p>
                
                <!-- Önerilen Semboller -->
                <div class="mt-4">
                    <h5><i class="fas fa-star"></i> Popüler Semboller</h5>
                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                        <span class="badge bg-secondary p-2" onclick="searchSymbol('THYAO')">THYAO</span>
                        <span class="badge bg-secondary p-2" onclick="searchSymbol('BTCUSDT')">BTCUSDT</span>
                        <span class="badge bg-secondary p-2" onclick="searchSymbol('AAPL')">AAPL</span>
                        <span class="badge bg-secondary p-2" onclick="searchSymbol('XAUUSD')">XAUUSD</span>
                        <span class="badge bg-secondary p-2" onclick="searchSymbol('EURUSD')">EURUSD</span>
                        <span class="badge bg-secondary p-2" onclick="searchSymbol('GARAN')">GARAN</span>
                        <span class="badge bg-secondary p-2" onclick="searchSymbol('MSFT')">MSFT</span>
                        <span class="badge bg-secondary p-2" onclick="searchSymbol('ETHUSDT')">ETHUSDT</span>
                    </div>
                </div>
                
                <!-- Arama Kutusu -->
                <div class="mt-5">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Sembol girin..." value="<?php echo $searched; ?>">
                        <button class="btn btn-primary" onclick="searchSymbolFromInput()">
                            <i class="fas fa-search"></i> Ara
                        </button>
                    </div>
                </div>
                
                <div class="mt-5">
                    <a href="/" class="btn btn-outline-primary">
                        <i class="fas fa-home"></i> Ana Sayfaya Dön
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-404 {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    border: 1px solid rgba(56, 189, 248, 0.2);
}
.badge {
    cursor: pointer;
    transition: all 0.3s;
}
.badge:hover {
    transform: translateY(-2px);
    background: #38bdf8 !important;
}
.form-control {
    background: rgba(15,23,42,0.8);
    border-color: rgba(56,189,248,0.3);
    color: white;
}
.form-control:focus {
    background: rgba(15,23,42,0.9);
    border-color: #38bdf8;
    box-shadow: 0 0 0 0.2rem rgba(56,189,248,0.25);
}
</style>

<script>
function searchSymbol(symbol) {
    window.location.href = '/search.php?q=' + encodeURIComponent(symbol);
}

function searchSymbolFromInput() {
    const symbol = document.getElementById('searchInput').value.trim().toUpperCase();
    if(symbol) {
        window.location.href = '/search.php?q=' + encodeURIComponent(symbol);
    }
}

document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if(e.key === 'Enter') {
        searchSymbolFromInput();
    }
});
</script>

<?php include 'includes/footer.php'; ?>