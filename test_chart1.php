<?php
// test_chart1.php - Investing.com embed
$symbol = isset($_GET['s']) ? $_GET['s'] : 'SAHOL';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Investing.com Grafik Testi - <?php echo $symbol; ?></title>
</head>
<body>
    <h1>Investing.com Grafik Testi - <?php echo $symbol; ?></h1>
    
    <div class="investing-chart" style="height: 500px;">
        <iframe src="https://tr.investing.com/chart/<?php echo $symbol; ?>_technical" 
                width="100%" 
                height="500" 
                frameborder="0">
        </iframe>
    </div>
    
    <p>Not: Investing.com embed'i çalışmazsa manuel kontrol: 
    <a href="https://tr.investing.com/equities/<?php echo strtolower($symbol); ?>" target="_blank">
        https://tr.investing.com/equities/<?php echo strtolower($symbol); ?>
    </a>
    </p>
</body>
</html>