<?php
// test_chart3.php - Yahoo Finance
$symbol = isset($_GET['s']) ? $_GET['s'] : 'SAHOL.IS';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Yahoo Finance Test - <?php echo $symbol; ?></title>
</head>
<body>
    <h1>Yahoo Finance Grafik Testi - <?php echo $symbol; ?></h1>
    
    <iframe src="https://finance.yahoo.com/chart/<?php echo $symbol; ?>"
            width="100%" 
            height="600" 
            frameborder="0">
    </iframe>
    
    <p>Yahoo Finance için BIST hisseleri: <strong>SAHOL.IS</strong> formatında</p>
    <p>Alternatif link: <a href="https://finance.yahoo.com/quote/<?php echo $symbol; ?>" target="_blank">https://finance.yahoo.com/quote/<?php echo $symbol; ?></a></p>
</body>
</html>