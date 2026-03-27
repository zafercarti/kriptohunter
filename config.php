<?php
// config.php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();

// Veritabanı Ayarları
$dbHost = "localhost";
$dbUser = "u493091657_kripto";
$dbPass = "Zfr19847360*";
$dbName = "u493091657_kripto";

// OpenAI API Ayarları
$apiKey = "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";
$apiUrl = "https://api.openai.com/v1/chat/completions";

// Veritabanı bağlantısı
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
mysqli_set_charset($conn, "utf8mb4");

if (!$conn) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

// Site ayarları
$site_name = "KriptoHunter";
$site_url = "https://www.kriptohunter.com";
?>