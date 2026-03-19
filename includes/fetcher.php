<?php
require_once 'config.php';

// Tek bir sembol için veri çek
function fetch_single_data($symbol, $type = 'forex') {
    $api_key = FCS_API_KEY;
    $url = API_BASE_URL . "/$type/latest?symbols=$symbol&access_key=$api_key";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code == 200) {
        $data = json_decode($response, true);
        return $data['response'][0] ?? null;
    }
    return null;
}

// Header için kritik verileri çek
function get_header_ticker_data() {
    $cache_file = __DIR__ . '/../cache/header_data.json';
    $cache_time = 10; // 10 saniye cache
    
    // Cache kontrolü
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_time) {
        return json_decode(file_get_contents($cache_file), true);
    }
    
    $data = [
        'USDTRY' => fetch_single_data('USD/TRY', 'forex'),
        'EURTRY' => fetch_single_data('EUR/TRY', 'forex'),
        'GBPTRY' => fetch_single_data('GBP/TRY', 'forex'),
        'XAUUSD' => fetch_single_data('XAU/USD', 'forex'),
        'XAGUSD' => fetch_single_data('XAG/USD', 'forex'),
        'BRENT' => fetch_single_data('BRENT/USD', 'forex'), // Petrol
    ];
    
    // Gram altın hesapla (Ons altın * Dolar/TL / 31.10)
    if ($data['XAUUSD'] && $data['USDTRY']) {
        $ons_usd = floatval($data['XAUUSD']['c']);
        $usd_try = floatval($data['USDTRY']['c']);
        $gram_altin_tl = ($ons_usd * $usd_try) / 31.10;
        
        $data['GRAM_ALTIN'] = [
            's' => 'GA/TRY',
            'c' => $gram_altin_tl,
            'cp' => $data['XAUUSD']['cp'] // Aynı değişim yüzdesi
        ];
    }
    
    // Gram gümüş hesapla (Ons gümüş * Dolar/TL / 31.10)
    if ($data['XAGUSD'] && $data['USDTRY']) {
        $ons_usd = floatval($data['XAGUSD']['c']);
        $usd_try = floatval($data['USDTRY']['c']);
        $gram_gumus_tl = ($ons_usd * $usd_try) / 31.10;
        
        $data['GRAM_GUMUS'] = [
            's' => 'GG/TRY',
            'c' => $gram_gumus_tl,
            'cp' => $data['XAGUSD']['cp']
        ];
    }
    
    // Cache'e kaydet
    file_put_contents($cache_file, json_encode($data));
    
    return $data;
}

// Ana piyasa verileri (eski fonksiyon)
function get_all_market_data() {
    global $forex_symbols, $crypto_symbols, $gold_symbols, $cache_file, $cache_time;
    
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_time) {
        return json_decode(file_get_contents($cache_file), true);
    }
    
    $data = [
        'forex' => fetch_data($forex_symbols, 'forex'),
        'crypto' => fetch_data($crypto_symbols, 'crypto'),
        'gold' => fetch_data($gold_symbols, 'forex'),
        'last_update' => date('Y-m-d H:i:s')
    ];
    
    file_put_contents($cache_file, json_encode($data));
    
    return $data;
}

// Çoklu sembol için veri çek
function fetch_data($symbols, $type = 'forex') {
    $api_key = FCS_API_KEY;
    $symbols_str = implode(',', $symbols);
    
    $url = API_BASE_URL . "/$type/latest?symbols=$symbols_str&access_key=$api_key";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}
?>