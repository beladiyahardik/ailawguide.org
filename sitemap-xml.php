<?php
header('Content-Type: application/xml; charset=UTF-8');

$site = require __DIR__ . '/includes/site.php';
require __DIR__ . '/includes/blogger.php';

$basePath = rtrim((string) ($site['base_path'] ?? '/'), '/');
$siteUrl = rtrim((string) ($site['site_url'] ?? ''), '/');

$origin = '';
if ($siteUrl !== '') {
    $parts = parse_url($siteUrl);
    if (is_array($parts) && isset($parts['scheme'], $parts['host'])) {
        $origin = $parts['scheme'] . '://' . $parts['host'];
        if (isset($parts['port'])) {
            $origin .= ':' . $parts['port'];
        }
    }
}

if ($origin === '') {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
    $origin = $scheme . '://' . $host;
}

$toAbsolute = static function (string $url) use ($origin): string {
    if (preg_match('#^https?://#i', $url)) {
        return $url;
    }
    return $origin . $url;
};

$staticPaths = [
    $basePath . '/',
    $basePath . '/about',
    $basePath . '/contact',
    $basePath . '/privacy-policy',
    $basePath . '/cookie-policy',
    $basePath . '/terms',
    $basePath . '/disclaimer',
    $basePath . '/gdpr',
    $basePath . '/us-privacy-rights',
    $basePath . '/sitemap',
];

$posts = blogger_fetch_posts($site, 200);
$urls = [];

foreach ($staticPaths as $path) {
    $urls[] = [
        'loc' => $toAbsolute($path),
        'lastmod' => date('c'),
        'changefreq' => 'weekly',
        'priority' => $path === $basePath . '/' ? '1.0' : '0.7',
    ];
}

$authorSeen = [];
$categorySeen = [];

foreach ($posts as $post) {
    $urls[] = [
        'loc' => $toAbsolute((string) ($post['url'] ?? '')),
        'lastmod' => (string) ($post['date_modified_iso'] ?? $post['date_iso'] ?? date('c')),
        'changefreq' => 'weekly',
        'priority' => '0.8',
    ];

    $authorUrl = (string) ($post['author']['url'] ?? '');
    if ($authorUrl !== '' && !isset($authorSeen[$authorUrl])) {
        $authorSeen[$authorUrl] = true;
        $urls[] = [
            'loc' => $toAbsolute($authorUrl),
            'lastmod' => date('c'),
            'changefreq' => 'monthly',
            'priority' => '0.6',
        ];
    }

    $categoryUrl = (string) ($post['category_url'] ?? '');
    if ($categoryUrl !== '' && !isset($categorySeen[$categoryUrl])) {
        $categorySeen[$categoryUrl] = true;
        $urls[] = [
            'loc' => $toAbsolute($categoryUrl),
            'lastmod' => date('c'),
            'changefreq' => 'weekly',
            'priority' => '0.7',
        ];
    }
}

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $entry): ?>
  <url>
    <loc><?php echo htmlspecialchars($entry['loc'], ENT_XML1, 'UTF-8'); ?></loc>
    <lastmod><?php echo htmlspecialchars($entry['lastmod'], ENT_XML1, 'UTF-8'); ?></lastmod>
    <changefreq><?php echo htmlspecialchars($entry['changefreq'], ENT_XML1, 'UTF-8'); ?></changefreq>
    <priority><?php echo htmlspecialchars($entry['priority'], ENT_XML1, 'UTF-8'); ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
