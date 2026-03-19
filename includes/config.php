<?php
// API anahtarı
define('FCS_API_KEY', 'RVMfELNnnQRAMhHuBZ1hFdOOISDB2');
define('API_BASE_URL', 'https://api-v4.fcsapi.com');

// Takip edilecek semboller
$forex_symbols = ['USD/TRY', 'EUR/TRY', 'GBP/TRY', 'EUR/USD', 'USD/JPY'];
$crypto_symbols = ['BTC/USD', 'ETH/USD', 'XRP/USD'];
$gold_symbols = ['XAU/USD'];

// Cache ayarları (30 saniye)
$cache_file = __DIR__ . '/../cache/market_data.json';
$cache_time = 30;
?>