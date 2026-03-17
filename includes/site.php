<?php
$scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
$scriptDir = trim(dirname($scriptName), '/.');
$detectedBasePath = $scriptDir === '' ? '/' : ('/' . $scriptDir);
$scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
$detectedSiteUrl = $scheme . '://' . $host . ($detectedBasePath === '/' ? '' : $detectedBasePath);

return [
    'site_name' => 'AI Law Guide',
    'site_url' => $detectedSiteUrl,
    'base_path' => $detectedBasePath,
    'author_name' => 'Rahul Beladiya',
    'author_profile_url' => '',
    'contact_email' => 'rcbeladiya@gmail.com',
    'tagline' => 'Practical tutorials on AI law, web, business, and technology.',
    'updated_at' => 'February 18, 2026',
    'blogger_blog_id' => '2686289342782868722',
    'blogger_api_key' => 'AIzaSyDw4oUW9oN8DfN5u6CUgFJ5rE7CF512l_0',
    'nav' => [
        'Home' => '',
        'About' => 'about',
        'Contact' => 'contact',
        'Privacy Policy' => 'privacy-policy',
        'Cookie Policy' => 'cookie-policy',
    ],
];

