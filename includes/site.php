<?php
$scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
$scriptDir = trim(dirname($scriptName), '/.');
$detectedBasePath = $scriptDir === '' ? '/' : ('/' . $scriptDir);
$scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
$detectedSiteUrl = $scheme . '://' . $host . ($detectedBasePath === '/' ? '' : $detectedBasePath);

return [
    'site_name'          => 'AI Law Guide',
    'site_url'           => $detectedSiteUrl,
    'base_path'          => $detectedBasePath,
    'author_name'        => 'Rahul Beladiya',
    'author_title'       => 'AI Developer & Regulatory Researcher',
    'author_bio'         => 'Rahul Beladiya is an AI developer who has spent years building production AI systems and tracking how global regulation intersects with real engineering work. He founded AI Law Guide to give developers and product teams a plain-language resource for understanding compliance, without all the legal theater.',
    'author_profile_url' => '',
    'author_linkedin'    => '',
    'author_github'      => 'https://github.com/rcbeladiya',
    'contact_email'      => 'rcbeladiya@gmail.com',
    'tagline'            => 'Practical guides on AI law, compliance, and governance for builders and product teams.',
    'updated_at'         => 'April 22, 2026',
    'blogger_blog_id'    => '2686289342782868722',
    'blogger_api_key'    => 'AIzaSyDw4oUW9oN8DfN5u6CUgFJ5rE7CF512l_0',
    'blogger_cache_ttl'  => 3600,
    'nav' => [
        'Home'          => '',
        'About'         => 'about',
        'Contact'       => 'contact',
        'Privacy Policy'=> 'privacy-policy',
        'Cookie Policy' => 'cookie-policy',
    ],
];
