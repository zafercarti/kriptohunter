<?php
// test_tv.php
require_once 'config.php';

$symbol = isset($_GET['s']) ? $_GET['s'] : 'BTCUSDT';
$type = isset($_GET['t']) ? $_GET['t'] : 'crypto';

if($type == 'crypto') {
    $tvSymbol = "BINANCE:" . $symbol;
} elseif($type == 'stock') {
    // BIST hisseleri için direkt sembol
    $tvSymbol = $symbol;
} elseif($type == 'stock_direct') {
    $tvSymbol = $symbol;
} elseif($type == 'us_stock') {
    $tvSymbol = "NASDAQ:" . $symbol;
} elseif($type == 'commodity') {
    if($symbol == 'XAUUSD') $tvSymbol = "TVC:GOLD";
    elseif($symbol == 'XAGUSD') $tvSymbol = "TVC:SILVER";
    else $tvSymbol = "TVC:" . $symbol;
} else {
    $tvSymbol = $symbol;
}

echo "<h1>TradingView Test</h1>";
echo "Sembol: $symbol<br>";
echo "Tip: $type<br>";
echo "TV Format: $tvSymbol<br><br>";
?>

<div id="tv_chart" style="height: 500px;"></div>

<script src="https://s3.tradingview.com/tv.js"></script>
<script>
setTimeout(function() {
    new TradingView.widget({
        "width": "100%",
        "height": 500,
        "symbol": "<?php echo $tvSymbol; ?>",
        "interval": "D",
        "timezone": "Etc/UTC",
        "theme": "dark",
        "style": "1",
        "locale": "tr",
        "enable_publishing": false,
        "container_id": "tv_chart"
    });
}, 200);
</script>