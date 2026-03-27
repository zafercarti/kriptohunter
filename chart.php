<?php
// chart.php - Gerçek verili grafik
$symbol = isset($_GET['s']) ? $_GET['s'] : 'SAHOL';
$yahooSymbol = $symbol . '.IS'; // BIST için .IS eki
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $symbol; ?> Grafik - KriptoHunter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #0a0c12;
            color: #e2e8f0;
            font-family: monospace;
        }
        #chart {
            height: 550px;
            background: rgba(15,23,42,0.6);
            border-radius: 16px;
        }
        .price-info {
            background: linear-gradient(135deg, rgba(56,189,248,0.1), rgba(129,140,248,0.05));
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .price-up { color: #10b981; }
        .price-down { color: #ef4444; }
        .loading {
            text-align: center;
            padding: 50px;
        }
    </style>
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-4">
    <div class="price-info" id="priceInfo">
        <div class="loading">Yükleniyor...</div>
    </div>
    
    <div id="chart"></div>
    
    <div class="alert alert-warning mt-3">
        <i class="fas fa-info-circle"></i>
        <strong>Veri Kaynağı:</strong> Yahoo Finance | <strong>Gecikme:</strong> 15 dakika
        <br>⚠️ Bu grafik yatırım tavsiyesi değildir.
    </div>
</div>

<script>
$(document).ready(function() {
    const yahooSymbol = '<?php echo $yahooSymbol; ?>';
    const symbol = '<?php echo $symbol; ?>';
    
    // Fiyat verisini çek
    $.ajax({
        url: '/api/price.php?s=' + yahooSymbol,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                // Fiyat bilgisini göster
                let changeClass = response.change >= 0 ? 'price-up' : 'price-down';
                let changeSign = response.change >= 0 ? '+' : '';
                
                $('#priceInfo').html(`
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h1>${symbol}</h1>
                            <p class="text-muted">${response.name}</p>
                        </div>
                        <div class="text-end">
                            <h2>${response.currentPrice.toFixed(2)} ₺</h2>
                            <p class="${changeClass}">
                                ${changeSign}${response.change.toFixed(2)} (${changeSign}${response.changePercent.toFixed(2)}%)
                            </p>
                            <small class="text-muted">Önceki Kapanış: ${response.previousClose.toFixed(2)} ₺</small>
                        </div>
                    </div>
                `);
                
                // Grafiği çiz
                drawChart(response.data);
            } else {
                $('#priceInfo').html('<div class="alert alert-danger">Veri alınamadı: ' + (response.error || 'Bilinmeyen hata') + '</div>');
            }
        },
        error: function() {
            $('#priceInfo').html('<div class="alert alert-danger">Bağlantı hatası! Lütfen daha sonra tekrar deneyin.</div>');
        }
    });
    
    function drawChart(data) {
        const chart = LightweightCharts.createChart(document.getElementById('chart'), {
            width: document.getElementById('chart').clientWidth,
            height: 550,
            layout: {
                backgroundColor: '#0a0c12',
                textColor: '#e2e8f0',
            },
            grid: {
                vertLines: { color: '#1e293b' },
                horzLines: { color: '#1e293b' },
            },
            crosshair: {
                mode: LightweightCharts.CrosshairMode.Normal,
            },
            rightPriceScale: {
                borderColor: '#38bdf8',
            },
            timeScale: {
                borderColor: '#38bdf8',
                timeVisible: true,
                secondsVisible: false,
            },
        });
        
        // Mum grafiği (Candlestick)
        const candlestickSeries = chart.addCandlestickSeries({
            upColor: '#10b981',
            downColor: '#ef4444',
            borderVisible: false,
            wickUpColor: '#10b981',
            wickDownColor: '#ef4444',
        });
        
        // Veriyi formatla
        const chartData = data.map(item => ({
            time: item.time / 1000,
            open: item.open,
            high: item.high,
            low: item.low,
            close: item.close,
        }));
        
        candlestickSeries.setData(chartData);
        
        // Hacim grafiği
        const volumeSeries = chart.addHistogramSeries({
            color: '#38bdf8',
            priceFormat: {
                type: 'volume',
            },
            priceScaleId: '',
            scaleMargins: {
                top: 0.8,
                bottom: 0,
            },
        });
        
        const volumeData = data.map(item => ({
            time: item.time / 1000,
            value: item.volume,
            color: item.close >= item.open ? '#10b981' : '#ef4444',
        }));
        
        volumeSeries.setData(volumeData);
        
        // Pencere boyutu değişince grafiği yeniden boyutlandır
        window.addEventListener('resize', function() {
            chart.applyOptions({ width: document.getElementById('chart').clientWidth });
        });
    }
});
</script>

</body>
</html>