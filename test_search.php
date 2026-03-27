<?php
// test_search.php - Arama testi
require_once 'config.php';

$q = isset($_GET['q']) ? $_GET['q'] : '';
echo "<h1>Arama Testi</h1>";
echo "Aranan: " . htmlspecialchars($q) . "<br>";

if(!empty($q)) {
    $symbol = strtoupper($q);
    
    // Veritabanında ara
    $query = "SELECT * FROM assets WHERE symbol = '$symbol'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $asset = mysqli_fetch_assoc($result);
        echo "<span style='color:green'>✅ Veritabanında bulundu: " . $asset['symbol'] . " - " . $asset['name'] . "</span><br>";
        echo "Slug: " . $asset['slug'] . "<br>";
        echo "Tip: " . $asset['type'] . "<br>";
    } else {
        echo "<span style='color:orange'>⚠️ Veritabanında bulunamadı</span><br>";
    }
    
    // TradingView kontrolü
    echo "<br>📡 TradingView kontrolü yapılıyor...<br>";
    
    $searchUrl = "https://symbol-search.tradingview.com/symbol_search/?text=" . urlencode($symbol) . "&type=all";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $searchUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if($httpCode == 200 && $response) {
        $results = json_decode($response, true);
        if(is_array($results) && count($results) > 0) {
            echo "<span style='color:green'>✅ TradingView'de bulundu!</span><br>";
            foreach($results as $item) {
                if(strtoupper($item['symbol'] ?? '') == $symbol || strtoupper($item['ticker'] ?? '') == $symbol) {
                    echo "Eşleşen: " . $item['symbol'] . " - Borsa: " . ($item['exchange'] ?? 'UNKNOWN') . "<br>";
                }
            }
        } else {
            echo "<span style='color:red'>❌ TradingView'de bulunamadı</span><br>";
        }
    } else {
        echo "<span style='color:red'>❌ TradingView bağlantı hatası (HTTP $httpCode)</span><br>";
    }
}
?>

<form method="get">
    <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Sembol girin">
    <button type="submit">Test Et</button>
</form>