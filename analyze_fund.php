<?php
// analyze_fund.php - Fon Analizi API
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Geçersiz istek']);
    exit;
}

$code = isset($_POST['code']) ? $_POST['code'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$daily_return = isset($_POST['daily_return']) ? $_POST['daily_return'] : 0;
$weekly_return = isset($_POST['weekly_return']) ? $_POST['weekly_return'] : 0;
$monthly_return = isset($_POST['monthly_return']) ? $_POST['monthly_return'] : 0;
$yearly_return = isset($_POST['yearly_return']) ? $_POST['yearly_return'] : 0;
$risk_value = isset($_POST['risk_value']) ? $_POST['risk_value'] : 5;

if(empty($code)) {
    echo json_encode(['success' => false, 'error' => 'Fon kodu boş olamaz']);
    exit;
}

$prompt = "Sen profesyonel bir yatırım fonu analistisin. Aşağıdaki fon için detaylı bir analiz yap:

Fon Kodu: $code
Fon Adı: $name
Kategori: $category
Günlük Getiri: $daily_return%
Haftalık Getiri: $weekly_return%
Aylık Getiri: $monthly_return%
Yıllık Getiri: $yearly_return%
Risk Seviyesi: $risk_value/10

Analizinde şunları belirt:
1. FON HAKKINDA GENEL DEĞERLENDİRME
2. PERFORMANS ANALİZİ (Kısa ve uzun vadeli getiriler)
3. RİSK ANALİZİ
4. FON YÖNETİMİ DEĞERLENDİRMESİ
5. YATIRIMCI PROFİLİNE UYGUNLUK
6. SONUÇ VE ÖNERİ

**KARAR:** [AL / SAT / TUT]
**GÜVEN:** [0-100]%

Analizi profesyonel bir fon analisti gibi yaz, Türkçe cevap ver.";

$data = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'system', 'content' => 'Sen profesyonel bir yatırım fonu analistisin. Yatırım fonları hakkında detaylı ve objektif analizler yaparsın.'],
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
curl_close($ch);

if ($httpCode !== 200) {
    echo json_encode(['success' => false, 'error' => 'API Hatası: ' . $response]);
    exit;
}

$result = json_decode($response, true);
$analysis = $result['choices'][0]['message']['content'];

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

echo json_encode([
    'success' => true,
    'code' => $code,
    'analysis' => $analysis,
    'recommendation' => $recommendation,
    'confidence' => $confidence
]);
?>