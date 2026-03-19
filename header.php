<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kriptohunter - Canlı Piyasa Verileri</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/css/style.css">
    
    <style>
        /* GEÇİCİ CSS - EĞER DIŞ CSS ÇALIŞMAZSA */
        .temp-test { display: none; }
    </style>
</head>
<body>
    <!-- PREMIUM TICKER - En üst şerit -->
    <div class="premium-ticker">
        <div class="ticker-container">
            <div class="ticker-left">
                <div class="live-indicator">
                    <span class="pulse"></span>
                    <span class="live-text">CANLI</span>
                </div>
                <div class="market-status">
                    <i class="fas fa-circle"></i>
                    <span>Piyasalar Açık</span>
                </div>
            </div>
            
            <div class="ticker-wrapper" id="premium-ticker">
                <!-- ÖRNEK VERİLER -->
                <div class="ticker-item">
                    <span class="ticker-symbol">USD/TRY</span>
                    <span class="ticker-price">32.45</span>
                    <span class="ticker-change positive">▲ 0.24%</span>
                </div>
                <div class="ticker-item">
                    <span class="ticker-symbol">EUR/TRY</span>
                    <span class="ticker-price">35.12</span>
                    <span class="ticker-change negative">▼ 0.08%</span>
                </div>
                <div class="ticker-item">
                    <span class="ticker-symbol">GBP/TRY</span>
                    <span class="ticker-price">41.08</span>
                    <span class="ticker-change positive">▲ 0.31%</span>
                </div>
                <div class="ticker-item">
                    <span class="ticker-symbol">ONS ALTIN</span>
                    <span class="ticker-price">$2,345</span>
                    <span class="ticker-change positive">▲ 0.45%</span>
                </div>
                <div class="ticker-item">
                    <span class="ticker-symbol">GRAM ALTIN</span>
                    <span class="ticker-price">₺2,456</span>
                    <span class="ticker-change negative">▼ 0.12%</span>
                </div>
                <div class="ticker-item">
                    <span class="ticker-symbol">BRENT</span>
                    <span class="ticker-price">$85.34</span>
                    <span class="ticker-change positive">▲ 1.23%</span>
                </div>
                <div class="ticker-item">
                    <span class="ticker-symbol">BITCOIN</span>
                    <span class="ticker-price">$43,256</span>
                    <span class="ticker-change positive">▲ 2.34%</span>
                </div>
            </div>
            
            <div class="ticker-right">
                <div class="date-display">
                    <i class="far fa-calendar"></i>
                    <span><?php echo strtoupper(date('d M Y')); ?></span>
                </div>
                <div class="time-display" id="live-clock">
                    <i class="far fa-clock"></i>
                    <span><?php echo date('H:i'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- ANA HEADER -->
    <header class="premium-header">
        <div class="header-container">
            <!-- LOGO -->
            <div class="logo-section">
                <a href="/" class="premium-logo">
                    <div class="logo-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="logo-text">
                        <span class="logo-main">KRİPTO</span>
                        <span class="logo-sub">HUNTER</span>
                    </div>
                </a>
                <div class="logo-badge">BETA</div>
            </div>

            <!-- MENÜ -->
            <nav class="premium-nav">
                <ul class="nav-menu">
                    <li class="nav-item active">
                        <a href="/">
                            <i class="fas fa-home"></i>
                            <span>Ana Sayfa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-coins"></i>
                            <span>Döviz</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-gem"></i>
                            <span>Altın</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            <i class="fab fa-bitcoin"></i>
                            <span>Kripto</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-chart-line"></i>
                            <span>Borsa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-droplet"></i>
                            <span>Emtia</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-percent"></i>
                            <span>Faiz</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- SAĞ BÖLÜM -->
            <div class="header-actions">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Sembol ara...">
                </div>
                
                <button class="action-button">
                    <i class="far fa-bell"></i>
                </button>
                
                <button class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>