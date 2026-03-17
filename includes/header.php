<?php
$cacheTtl = 60 * 60 * 24;
$cacheBuffering = false;
$requestUri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
$cacheKey = hash('sha256', $requestUri);
$cacheDir = __DIR__ . '/../cache';
$cacheFile = $cacheDir . '/' . $cacheKey . '.html';
$cacheEnabled = (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET')
    && (strpos($requestUri, 'nocache=1') === false);

if ($cacheEnabled) {
    if (is_file($cacheFile) && (time() - filemtime($cacheFile) < $cacheTtl)) {
        header('X-Cache: HIT');
        readfile($cacheFile);
        exit;
    }

    if (is_dir($cacheDir) || @mkdir($cacheDir, 0755, true)) {
        $cacheBuffering = true;
        ob_start();
    }
}

$site = require __DIR__ . '/site.php';
if (!isset($pageTitle) || $pageTitle === '') {
    $pageTitle = $site['site_name'];
}
if (!isset($metaDescription) || $metaDescription === '') {
    $metaDescription = $site['tagline'];
}
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
$basePath    = rtrim((string) ($site['base_path'] ?? '/'), '/');
$siteUrl     = rtrim((string) ($site['site_url'] ?? ''), '/');
$requestUri  = (string) ($_SERVER['REQUEST_URI'] ?? '/');
$scheme      = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host        = (string) ($_SERVER['HTTP_HOST'] ?? '');
$currentUrl  = $host !== '' ? ($scheme . '://' . $host . $requestUri) : ($siteUrl . ($currentPath !== '' ? $currentPath : '/'));
$hasExtraHeadTags = isset($extraHeadTags) && trim((string) $extraHeadTags) !== '';
$metaRobots = isset($metaRobots) && trim((string) $metaRobots) !== '' ? (string) $metaRobots : 'index, follow';
$buildNavHref = static function (string $url, string $basePath): string {
    if ($url === '') {
        return $basePath === '' ? '/' : ($basePath . '/');
    }

    if (preg_match('#^(https?:)?//#i', $url) || str_starts_with($url, 'mailto:') || str_starts_with($url, 'tel:') || str_starts_with($url, '#')) {
        return $url;
    }

    if (str_starts_with($url, '/')) {
        return $url;
    }

    return ($basePath === '' ? '' : $basePath) . '/' . ltrim($url, '/');
};
$faviconPath = '/favicon.png';
$faviconHref = $siteUrl !== '' ? ($siteUrl . $faviconPath) : ($basePath . $faviconPath);
$faviconFile = __DIR__ . '/../favicon.png';
$faviconVer  = is_file($faviconFile) ? (string) filemtime($faviconFile) : '';
if ($faviconVer !== '') {
    $faviconHref .= '?v=' . rawurlencode($faviconVer);
}
$tailwindPath = '/assets/css/tailwind.css';
$tailwindHref = $siteUrl !== '' ? ($siteUrl . $tailwindPath) : ($basePath . $tailwindPath);
$tailwindFile = __DIR__ . '/../assets/css/tailwind.css';
$tailwindVer = is_file($tailwindFile) ? (string) filemtime($tailwindFile) : '';
if ($tailwindVer !== '') {
    $tailwindHref .= '?v=' . rawurlencode($tailwindVer);
}
$stylePath = '/assets/css/style.css';
$styleHref = $siteUrl !== '' ? ($siteUrl . $stylePath) : ($basePath . $stylePath);
$styleFile = __DIR__ . '/../assets/css/style.css';
$styleVer = is_file($styleFile) ? (string) filemtime($styleFile) : '';
if ($styleVer !== '') {
    $styleHref .= '?v=' . rawurlencode($styleVer);
}
$iconsPath = '/assets/vendor/bootstrap-icons/bootstrap-icons.css';
$iconsHref = $siteUrl !== '' ? ($siteUrl . $iconsPath) : ($basePath . $iconsPath);
$iconsFile = __DIR__ . '/../assets/vendor/bootstrap-icons/bootstrap-icons.css';
$iconsVer = is_file($iconsFile) ? (string) filemtime($iconsFile) : '';
if ($iconsVer !== '') {
    $iconsHref .= '?v=' . rawurlencode($iconsVer);
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo htmlspecialchars($faviconHref, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="shortcut icon" href="<?php echo htmlspecialchars($faviconHref, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="apple-touch-icon" href="<?php echo htmlspecialchars($faviconHref, ENT_QUOTES, 'UTF-8'); ?>">

    <?php if (!$hasExtraHeadTags): ?>
        <link rel="canonical" href="<?php echo htmlspecialchars($currentUrl, ENT_QUOTES, 'UTF-8'); ?>">
        <meta name="robots" content="<?php echo htmlspecialchars($metaRobots, ENT_QUOTES, 'UTF-8'); ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
        <meta property="og:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
        <meta property="og:url" content="<?php echo htmlspecialchars($currentUrl, ENT_QUOTES, 'UTF-8'); ?>">
        <meta property="og:site_name" content="<?php echo htmlspecialchars($site['site_name'] ?? 'AI Law Guide', ENT_QUOTES, 'UTF-8'); ?>">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
        <meta name="twitter:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
        <meta name="author" content="<?php echo htmlspecialchars($site['site_name'] ?? 'AI Law Guide', ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>

    <?php echo $extraHeadTags ?? ''; ?>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5643507166119131"
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="<?php echo htmlspecialchars($tailwindHref, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($styleHref, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($iconsHref, ENT_QUOTES, 'UTF-8'); ?>">
    <style>
        /* Article body typography */
        .article-content {
            color: #334155;
            line-height: 1.8;
            word-break: break-word;
        }

        .article-content h1,
        .article-content h2,
        .article-content h3,
        .article-content h4,
        .article-content h5,
        .article-content h6 {
            color: #0f172a;
            font-weight: 700;
            line-height: 1.3;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .article-content h1 {
            font-size: 1.75rem;
        }

        .article-content h2 {
            font-size: 1.5rem;
        }

        .article-content h3 {
            font-size: 1.25rem;
        }

        .article-content p {
            margin-top: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .article-content ul,
        .article-content ol {
            margin-top: 0.85rem;
            margin-bottom: 0.85rem;
            padding-left: 1.5rem;
        }

        .article-content ul {
            list-style: disc;
        }

        .article-content ol {
            list-style: decimal;
        }

        .article-content li {
            margin: 0.35rem 0;
            padding-left: 0.15rem;
        }

        .article-content li>ul,
        .article-content li>ol {
            margin-top: 0.35rem;
            margin-bottom: 0.35rem;
        }

        .article-content blockquote {
            margin: 1rem 0;
            border-left: 4px solid #14b8a6;
            padding: 0.5rem 0 0.5rem 1rem;
            color: #475569;
            background: #f8fafc;
            border-radius: 0.25rem;
        }

        .article-content a {
            color: #0f172a;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .article-content a:hover {
            color: #0f766e;
        }

        .article-content img,
        .article-content iframe,
        .article-content video {
            display: block;
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 0.85rem auto;
        }

        .article-content pre {
            overflow-x: auto;
            max-width: 100%;
            margin: 1rem 0;
            background: #0f172a;
            color: #e2e8f0;
            padding: 0.85rem 1rem;
            border-radius: 0.5rem;
        }

        .article-content code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas,
                "Liberation Mono", "Courier New", monospace;
            background: #f1f5f9;
            color: #0f172a;
            padding: 0.15rem 0.3rem;
            border-radius: 0.3rem;
            font-size: 0.9em;
        }

        .article-content pre code {
            background: transparent;
            color: inherit;
            padding: 0;
        }

        .article-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .article-content .table-wrap {
            overflow-x: auto;
        }

        .article-content th,
        .article-content td {
            border: 1px solid #e2e8f0;
            padding: 0.55rem 0.7rem;
            text-align: left;
            vertical-align: top;
        }

        .article-content th {
            background: #f8fafc;
            color: #0f172a;
            font-weight: 600;
        }

        .article-content hr {
            border: 0;
            border-top: 1px solid #e2e8f0;
            margin: 1.5rem 0;
        }

        @media (max-width: 640px) {
            .article-content table {
                min-width: 480px;
            }

            .article-content h1 {
                font-size: 1.5rem;
            }

            .article-content h2 {
                font-size: 1.25rem;
            }

            .article-content h3 {
                font-size: 1.1rem;
            }
        }

        /* Mobile nav drawer */
        #nav-drawer {
            display: none;
        }

        #nav-drawer.open {
            display: flex;
        }

        /* Smooth hamburger to X transition */
        #menu-btn[aria-expanded="true"] .bar-top {
            transform: translateY(6px) rotate(45deg);
        }

        #menu-btn[aria-expanded="true"] .bar-mid {
            opacity: 0;
            transform: scaleX(0);
        }

        #menu-btn[aria-expanded="true"] .bar-bottom {
            transform: translateY(-6px) rotate(-45deg);
        }

        .bar-top,
        .bar-mid,
        .bar-bottom {
            transition: transform 0.2s ease, opacity 0.15s ease;
            transform-origin: center;
        }

        .bi {
            display: inline-block;
            color: currentColor;
            line-height: 1;
        }

        /* Blog list cards: stable across mobile and desktop */
        .blog-list-card {
            display: grid;
            grid-template-columns: 1fr;
        }

        .blog-list-thumb {
            width: 100%;
            overflow: hidden;
            background: #f8fafc;
        }

        .blog-list-img {
            display: block;
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .blog-list-body {
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (min-width: 640px) {
            .blog-list-card {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="min-h-screen font-sans text-slate-900 antialiased ads-hidden">
    <a class="skip-link" href="#main-content">Skip to content</a>

    <!-- Site header -->
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
        <div class="mx-auto max-w-6xl px-4">
            <div class="flex h-14 items-center justify-between gap-4 sm:h-16">

                <!-- Logo / site name -->
                <div class="flex items-center gap-3">
                    <a class="shrink-0 text-lg font-semibold tracking-tight text-slate-900 hover:text-slate-700 sm:text-xl"
                    href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($site['site_name'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                    <span class="hidden text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-500 md:inline">
                        Global AI regulation briefings
                    </span>
                </div>

                <!-- Desktop nav (hidden on mobile) -->
                <nav class="hidden items-center gap-1 sm:flex" aria-label="Primary navigation">
                    <?php foreach ($site['nav'] as $label => $url):
                        $href = $buildNavHref((string) $url, $basePath);
                        $hrefPath = parse_url($href, PHP_URL_PATH);
                        $active = is_string($hrefPath) && $hrefPath !== ''
                            ? (rtrim($currentPath, '/') === rtrim($hrefPath, '/'))
                            : false;
                        if ($url === '' && ($currentPath === $basePath || $currentPath === $basePath . '/' || $currentPath === $basePath . '/index.php')) {
                            $active = true;
                        }
                    ?>
                        <a href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>"
                            class="whitespace-nowrap rounded-full px-3.5 py-1.5 text-sm font-semibold transition
                              <?php echo $active
                                    ? 'bg-brand-600 text-white'
                                    : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'; ?>"
                            <?php echo $active ? 'aria-current="page"' : ''; ?>>
                            <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>

                <!-- Hamburger button (mobile only) -->
                <button id="menu-btn"
                    type="button"
                    aria-controls="nav-drawer"
                    aria-expanded="false"
                    aria-label="Toggle navigation menu"
                    class="flex h-10 w-10 flex-col items-center justify-center gap-[5px] rounded-lg
                           border border-slate-200 bg-white p-2 text-slate-700 transition hover:bg-slate-100 sm:hidden">
                    <span class="bar-top  block h-0.5 w-5 rounded bg-current"></span>
                    <span class="bar-mid  block h-0.5 w-5 rounded bg-current"></span>
                    <span class="bar-bottom block h-0.5 w-5 rounded bg-current"></span>
                </button>

            </div>
        </div>

        <!-- Mobile nav drawer -->
        <div id="nav-drawer"
            class="flex-col gap-1 border-t border-slate-100 bg-white px-4 pb-4 pt-3 sm:hidden"
            aria-label="Mobile navigation">
            <?php foreach ($site['nav'] as $label => $url):
                $href = $buildNavHref((string) $url, $basePath);
                $hrefPath = parse_url($href, PHP_URL_PATH);
                $active = is_string($hrefPath) && $hrefPath !== ''
                    ? (rtrim($currentPath, '/') === rtrim($hrefPath, '/'))
                    : false;
                if ($url === '' && ($currentPath === $basePath || $currentPath === $basePath . '/' || $currentPath === $basePath . '/index.php')) {
                    $active = true;
                }
            ?>
                <a href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>"
                    class="flex items-center rounded-xl px-4 py-2.5 text-sm font-semibold transition
                      <?php echo $active
                            ? 'bg-brand-600 text-white'
                            : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900'; ?>"
                    <?php echo $active ? 'aria-current="page"' : ''; ?>>
                    <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </header>

    <!-- <div class="ad-wrap sticky top-14 z-30 border-b border-slate-200 bg-slate-50/95 backdrop-blur supports-[backdrop-filter]:bg-white/80 sm:top-16">
        <div class="mx-auto max-w-6xl px-4 py-2">
            <div class="ad-slot flex h-14 items-center justify-center rounded-lg text-[11px] font-semibold tracking-[0.28em] text-slate-500">
                Leaderboard Ad Placeholder
            </div>
        </div>
    </div> -->

    <!-- Hamburger toggle script -->
    <script>
        (function() {
            const btn = document.getElementById('menu-btn');
            const drawer = document.getElementById('nav-drawer');
            if (!btn || !drawer) return;

            btn.addEventListener('click', function() {
                const isOpen = drawer.classList.toggle('open');
                btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            // Close drawer when a nav link is clicked
            drawer.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    drawer.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                });
            });

            // Close drawer on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && drawer.classList.contains('open')) {
                    drawer.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                    btn.focus();
                }
            });
        })();
    </script>

    <main id="main-content" class="mx-auto max-w-6xl px-4 py-6 sm:py-8 lg:py-10">

