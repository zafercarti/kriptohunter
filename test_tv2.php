<?php
// test_tv2.php
$symbol = isset($_GET['s']) ? $_GET['s'] : 'SAHOL';
?>

<!DOCTYPE html>
<html>
<head>
    <title>TradingView Test</title>
    <script src="https://s3.tradingview.com/tv.js"></script>
</head>
<body>
    <h1>TradingView Format Testi - <?php echo $symbol; ?></h1>
    
    <h3>1. Format: "BIST:<?php echo $symbol; ?>"</h3>
    <div id="tv1" style="height: 400px; margin-bottom: 20px;"></div>
    
    <h3>2. Format: "<?php echo $symbol; ?>"</h3>
    <div id="tv2" style="height: 400px; margin-bottom: 20px;"></div>
    
    <h3>3. Format: "BIST:<?php echo $symbol; ?>_E"</h3>
    <div id="tv3" style="height: 400px;"></div>
    
    <script>
    setTimeout(function() {
        // Test 1: BIST:SAHOL
        new TradingView.widget({
            "width": "100%",
            "height": 400,
            "symbol": "BIST:<?php echo $symbol; ?>",
            "interval": "D",
            "theme": "dark",
            "container_id": "tv1"
        });
        
        // Test 2: SAHOL
        new TradingView.widget({
            "width": "100%",
            "height": 400,
            "symbol": "<?php echo $symbol; ?>",
            "interval": "D",
            "theme": "dark",
            "container_id": "tv2"
        });
        
        // Test 3: BIST:SAHOL_E
        new TradingView.widget({
            "width": "100%",
            "height": 400,
            "symbol": "BIST:<?php echo $symbol; ?>_E",
            "interval": "D",
            "theme": "dark",
            "container_id": "tv3"
        });
    }, 500);
    </script>
</body>
</html>