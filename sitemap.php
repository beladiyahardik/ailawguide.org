<?php
require __DIR__ . '/includes/page-cache.php';
header('Content-Type: text/html; charset=UTF-8');
$site = require __DIR__ . '/includes/site.php';
require __DIR__ . '/includes/blogger.php';
$basePath = rtrim((string) ($site['base_path'] ?? '/'), '/');

$urls = [
    $basePath . '/',
    $basePath . '/about',
    $basePath . '/contact',
    $basePath . '/privacy-policy',
    $basePath . '/cookie-policy',
    $basePath . '/terms',
    $basePath . '/disclaimer',
    $basePath . '/gdpr',
    $basePath . '/us-privacy-rights',
];

$posts = blogger_fetch_posts($site, 50);
foreach ($posts as $post) {
    $urls[] = $post['url'];
}

$tailwindPath = '/assets/css/tailwind.css';
$siteUrl = rtrim((string) ($site['site_url'] ?? ''), '/');
$tailwindHref = $siteUrl !== '' ? ($siteUrl . $tailwindPath) : ($basePath . $tailwindPath);
$tailwindFile = __DIR__ . '/assets/css/tailwind.css';
$tailwindVer = is_file($tailwindFile) ? (string) filemtime($tailwindFile) : '';
if ($tailwindVer !== '') {
    $tailwindHref .= '?v=' . rawurlencode($tailwindVer);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemap | AI Law Guide</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($tailwindHref, ENT_QUOTES, 'UTF-8'); ?>">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YSM0PHETRT"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-YSM0PHETRT');
    </script>
</head>
<body class="bg-slate-50 text-slate-900">
    <main class="mx-auto max-w-4xl px-4 py-10">
        <h1 class="text-2xl font-bold">Sitemap</h1>
        <ul class="mt-5 list-disc space-y-2 pl-5">
            <?php foreach ($urls as $url): ?>
                <li><a class="underline" href="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>

