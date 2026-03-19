<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-cache, must-revalidate');

require_once '../includes/fetcher.php';

$data = get_header_ticker_data();
echo json_encode($data);
?>