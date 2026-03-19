<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Güvenlik için * yerine domain yazılabilir

require_once '../includes/fetcher.php';

$data = get_all_market_data();
echo json_encode($data);
?>