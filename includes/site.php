<?php
$scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
$scriptDir = trim(dirname($scriptName), '/.');
$detectedBasePath = $scriptDir === '' ? '/' : ('/' . $scriptDir);
$scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
$detectedSiteUrl = $scheme . '://' . $host . ($detectedBasePath === '/' ? '' : $detectedBasePath);
$authorSlug = 'rahul-beladiya';
$authorProfilePath = ($detectedBasePath === '/' ? '' : $detectedBasePath) . '/author/' . $authorSlug;
$authorProfileUrl = $detectedSiteUrl . '/author/' . $authorSlug;

return [
    'site_name'          => 'AI Law Guide',
    'site_url'           => $detectedSiteUrl,
    'base_path'          => $detectedBasePath,
    'page_cache_forever' => true,
    'blogger_cache_forever' => true,
    'author_name'        => 'Rahul Beladiya',
    'author_slug'        => $authorSlug,
    'author_title'       => 'Provides guidance on AI adoption within legal frameworks.',
    'author_sidebar_intro' => 'I assist legal teams and technology firms in navigating AI, legal technology, and digital empowerment.',
    'author_bio'         => 'I\'m a Legal Tech strategist and writer who focuses on the blend of law, AI, and digital change. Through my writing on the Legal Tech Ecosystem, I help in-house legal teams, law firms, and tech companies navigate the fast-changing world of artificial intelligence, legal tech tools, and digital support. Whether it\'s setting up AI-powered contract lifecycle management, creating future-ready legal operations, or choosing the right technology for compliance and efficiency, I break down complex innovations into practical, actionable strategies. My goal is straightforward: to provide legal professionals and tech leaders with the clarity and confidence they need to succeed in a technology-driven legal environment.',
    'author_profile_path'=> $authorProfilePath,
    'author_profile_url' => $authorProfileUrl,
    'author_linkedin'    => '',
    // 'author_github'      => 'https://github.com/rcbeladiya',
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
