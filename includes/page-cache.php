<?php
$cacheBuffering = false;
$requestUri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
$cacheKey = hash('sha256', $requestUri);
$cacheDir = __DIR__ . '/../cache';
$cacheFile = $cacheDir . '/' . $cacheKey . '.html';

$cacheEnabled = (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET')
    && (strpos($requestUri, 'nocache=1') === false);

if ($cacheEnabled && is_file($cacheFile)) {
    header('X-Cache: HIT');
    readfile($cacheFile);
    exit;
}

if ($cacheEnabled && (is_dir($cacheDir) || @mkdir($cacheDir, 0755, true))) {
    $cacheBuffering = true;
    ob_start();
}
