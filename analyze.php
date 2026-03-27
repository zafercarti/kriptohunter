<?php
// analyze.php - AI Analiz API
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['symbol'])) {
    echo json_encode(['success' => false, 'error' => 'Geçersiz istek']);
    exit;
}

$symbol = strtoupper(trim($_POST['symbol']));
$type = isset($_POST['type']) ? $_POST['type'] : 'stock';

if (empty($symbol)) {
    echo json_encode(['success' => false, 'error' => 'Sembol boş olamaz']);
    exit;
}

// Asset tipine göre prompt oluştur
$prompt = getPromptByType($symbol, $type);

$data = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'system', 'content' => 'Sen 20 yıllık deneyime sahip profesyonel bir teknik analist ve trader\'sın. Kesin ve net analizler yaparsın.'],
        ['role' => 'user', 'content' => $prompt]
    ],
    'temperature' => 0.7,
    'max_tokens' => 2000
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    echo json_encode(['success' => false, 'error' => 'cURL Hatası: ' . $curlError]);
    exit;
}

if ($httpCode !== 200) {
    echo json_encode(['success' => false, 'error' => 'API Hatası: ' . $response]);
    exit;
}

$result = json_decode($response, true);

if (!isset($result['choices'][0]['message']['content'])) {
    echo json_encode(['success' => false, 'error' => 'API yanıtında hata']);
    exit;
}

$analysis = $result['choices'][0]['message']['content'];

// Karar ve güven seviyesini çıkar
$recommendation = 'HOLD';
$confidence = 70;

if (preg_match('/KARAR:\s*\[?(AL|SAT|TUT)\]?/i', $analysis, $matches)) {
    $rec = strtoupper($matches[1]);
    if ($rec == 'AL') $recommendation = 'BUY';
    elseif ($rec == 'SAT') $recommendation = 'SELL';
    else $recommendation = 'HOLD';
}

if (preg_match('/GÜVEN:\s*\[?(\d+)\]?/i', $analysis, $matches)) {
    $confidence = intval($matches[1]);
    $confidence = min(100, max(0, $confidence));
}

// Asset ID'yi bul
$assetQuery = "SELECT id FROM assets WHERE symbol = '$symbol'";
$assetResult = mysqli_query($conn, $assetQuery);
$asset = mysqli_fetch_assoc($assetResult);
$asset_id = $asset ? $asset['id'] : null;

// Veritabanına kaydet
$stmt = $conn->prepare("INSERT INTO analyses (asset_id, symbol, analysis_text, recommendation, confidence, user_ip, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
$ip = $_SERVER['REMOTE_ADDR'];
$stmt->bind_param("issiis", $asset_id, $symbol, $analysis, $recommendation, $confidence, $ip);
$stmt->execute();
$stmt->close();

// Asset güncelleme
if($asset_id) {
    mysqli_query($conn, "UPDATE assets SET updated_at = NOW() WHERE id = $asset_id");
}

echo json_encode([
    'success' => true,
    'symbol' => $symbol,
    'analysis' => $analysis,
    'recommendation' => $recommendation,
    'confidence' => $confidence
]);

/**
 * Varlık tipine göre prompt oluştur
 */
function getPromptByType($symbol, $type) {
    $typeText = [
        'stock' => 'hisse senedi',
        'us_stock' => 'ABD borsası hisse senedi',
        'crypto' => 'kripto para',
        'fund' => 'yatırım fonu',
        'commodity' => 'emtia',
        'forex' => 'forex paritesi'
    ];
    
    $typeName = $typeText[$type] ?? 'finansal varlık';
    
    return "Sen profesyonel bir teknik analist ve trader'sın. $symbol için DETAYLI teknik analiz yap.

Analizinde şu başlıkları kullan ve MUTLAKA şu formatta yaz:

📊 **GENEL GÖRÜNÜM**
(Trend yönü, piyasa duygusu, momentum)

🟢 **DESTEK SEVİYELERİ**
(En önemli 3 destek seviyesi)

🔴 **DİRENÇ SEVİYELERİ**
(En önemli 3 direnç seviyesi)

📈 **İNDİKATÖR ANALİZİ**
(RSI: kaç? / MACD: durumu / Hareketli Ortalamalar)

📊 **VOLUM ANALİZİ**
(Hacim durumu ve yorumu)

⚠️ **RİSK YÖNETİMİ**
(Stop-loss önerisi, hedef seviyeler)

🎯 **SONUÇ VE ÖNERİ**
(Kesin karar ve gerekçe)

**KARAR:** [AL / SAT / TUT]
**GÜVEN:** [0-100]%

Analizi profesyonel bir trader gibi yaz, Türkçe cevap ver.";
}
?>