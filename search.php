<?php
// search.php
require_once 'config.php';
require_once 'includes/functions.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if(empty($q)) {
    header('Location: /');
    exit;
}

$symbol = strtoupper($q);

// Veritabanında ara
$query = "SELECT * FROM assets WHERE symbol = '$symbol' OR name LIKE '%$symbol%'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    $asset = mysqli_fetch_assoc($result);
    
    // Görüntülenme sayısını artır
    mysqli_query($conn, "UPDATE assets SET search_count = search_count + 1 WHERE id = {$asset['id']}");
    
    // Tipine göre yönlendir
    if($asset['type'] == 'stock') {
        header("Location: /hisse-senedi/detay.php?slug=" . $asset['slug']);
    } elseif($asset['type'] == 'us_stock') {
        header("Location: /abd-borsasi/detay.php?slug=" . $asset['slug']);
    } elseif($asset['type'] == 'crypto') {
        header("Location: /kripto/detay.php?slug=" . $asset['slug']);
    } elseif($asset['type'] == 'commodity') {
        header("Location: /emtia/detay.php?slug=" . $asset['slug']);
    } elseif($asset['type'] == 'fund') {
        header("Location: /fon/yatirim-fonlari/detay.php?code=" . $asset['symbol']);
    } else {
        header("Location: /detay.php?slug=" . $asset['slug']);
    }
    exit;
}

// ========== BULUNAMADI - TALEP OLUŞTUR ==========

// Önce pending_symbols tablosunda var mı kontrol et
$checkPending = "SELECT * FROM pending_symbols WHERE symbol = '$symbol' AND status = 'pending'";
$pendingResult = mysqli_query($conn, $checkPending);

if(mysqli_num_rows($pendingResult) == 0) {
    // Yeni talep ekle
    $insert = "INSERT INTO pending_symbols (symbol, type, requested_by, requested_at) 
               VALUES ('$symbol', 'stock', '{$_SERVER['REMOTE_ADDR']}', NOW())";
    mysqli_query($conn, $insert);
}

// Kullanıcıyı bekleme sayfasına yönlendir
header('Location: /pending.php?symbol=' . urlencode($symbol));
exit;
?>