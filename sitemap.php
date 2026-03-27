<?php
// sitemap.php - Otomatik XML Site Haritası
header('Content-Type: application/xml; charset=utf-8');
require_once 'config.php';

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Ana Sayfa
echo '<url>
    <loc>https://www.kriptohunter.com/</loc>
    <lastmod>' . date('Y-m-d') . '</lastmod>
    <priority>1.0</priority>
</url>';

// Kategori Sayfaları
$categories = [
    '/hisse-senedi/' => 'Hisse Senetleri',
    '/abd-borsasi/' => 'ABD Borsaları',
    '/kripto/' => 'Kripto Paralar',
    '/fon/yatirim-fonlari/' => 'Yatırım Fonları',
    '/emtia/' => 'Emtialar'
];

foreach($categories as $url => $name) {
    echo '<url>
        <loc>https://www.kriptohunter.com' . $url . '</loc>
        <lastmod>' . date('Y-m-d') . '</lastmod>
        <priority>0.9</priority>
    </url>';
}

// Asset Sayfaları
$assets = mysqli_query($conn, "SELECT slug, type, updated_at FROM assets WHERE tv_validated = 1 ORDER BY search_count DESC");
while($asset = mysqli_fetch_assoc($assets)) {
    $typePath = [
        'stock' => 'hisse-senedi',
        'us_stock' => 'abd-borsasi',
        'crypto' => 'kripto',
        'fund' => 'fon/yatirim-fonlari',
        'commodity' => 'emtia',
        'forex' => 'forex'
    ];
    $path = $typePath[$asset['type']] ?? 'detay';
    $lastmod = $asset['updated_at'] ? date('Y-m-d', strtotime($asset['updated_at'])) : date('Y-m-d');
    
    echo '<url>
        <loc>https://www.kriptohunter.com/' . $path . '/' . $asset['slug'] . '</loc>
        <lastmod>' . $lastmod . '</lastmod>
        <priority>0.8</priority>
    </url>';
}

echo '</urlset>';
?>