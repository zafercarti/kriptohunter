<?php
// test_chart2.php - TradingView Lightweight Chart
$symbol = isset($_GET['s']) ? $_GET['s'] : 'SAHOL';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lightweight Chart Test - <?php echo $symbol; ?></title>
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.js"></script>
</head>
<body>
    <h1>Lightweight Chart Test - <?php echo $symbol; ?></h1>
    <div id="chart" style="height: 500px;"></div>
    
    <script>
    // Örnek veri (gerçek veri için API gerekli)
    const chart = LightweightCharts.createChart(document.getElementById('chart'), {
        width: document.body.clientWidth - 50,
        height: 500,
        layout: {
            backgroundColor: '#0a0c12',
            textColor: '#e2e8f0',
        },
        grid: {
            vertLines: { color: '#1e293b' },
            horzLines: { color: '#1e293b' },
        },
    });
    
    const lineSeries = chart.addLineSeries({ color: '#38bdf8' });
    
    // Demo veri - Gerçek fiyatlar için API entegrasyonu gerekli
    const data = [
        { time: '2024-01-01', value: 100 },
        { time: '2024-02-01', value: 105 },
        { time: '2024-03-01', value: 98 },
        { time: '2024-04-01', value: 110 },
        { time: '2024-05-01', value: 115 },
        { time: '2024-06-01', value: 112 },
    ];
    
    lineSeries.setData(data);
    
    document.getElementById('chart').innerHTML += '<div class="alert alert-warning mt-3">⚠️ Bu demo grafiktir. Gerçek fiyatlar için veri API\'si entegrasyonu gereklidir.</div>';
    </script>
    
    <p><strong>Not:</strong> Lightweight Chart, TradingView'in ücretsiz hafif grafik kütüphanesidir. Gerçek veri için Yahoo Finance veya Alpha Vantage API entegrasyonu gerekir.</p>
</body>
</html>