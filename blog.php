<?php
$site = require __DIR__ . '/includes/site.php';
require __DIR__ . '/includes/blogger.php';
$blogDescription = blogger_blog_description($site);

$path    = (string) ($_GET['path']    ?? '');
$slug    = (string) ($_GET['slug']    ?? '');
$postId  = (string) ($_GET['post_id'] ?? '');

if ($postId === '' && $path !== '' && preg_match('/^(.*)-([0-9]+)$/', $path, $matches)) {
    $slug   = trim((string) $matches[1]);
    $postId = (string) $matches[2];
}

if ($postId === '') {
    $uriPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    if (is_string($uriPath) && preg_match('/-([0-9]+)\/?$/', $uriPath, $matches)) {
        $postId = (string) $matches[1];
    }
}

$posts        = blogger_fetch_posts($site, 30);
$selectedPost = $postId !== '' ? blogger_fetch_post_by_id($site, $postId) : null;
$apiError     = blogger_last_error();
$renderedContent = '';

if ($selectedPost !== null) {
    $renderedContent = (string) ($selectedPost['content'] ?? '');
    $renderedContent = preg_replace('/<table\b/i', '<div class="table-wrap"><table', $renderedContent);
    $renderedContent = str_ireplace('</table>', '</table></div>', $renderedContent);
    $renderedContent = blogger_strip_image_links($renderedContent);
    $renderedContent = blogger_localize_html_images($renderedContent, $site);
}

if ($selectedPost !== null && $slug !== '' && $slug !== $selectedPost['slug']) {
    header('Location: ' . $selectedPost['url'], true, 301);
    exit;
}

/* -- SEO / Meta ------------------------------------------------------------ */
$pageTitle       = $selectedPost ? ($selectedPost['title'] . ' | AI Law Guide') : 'Article | AI Law Guide';
$metaDescription = $selectedPost ? $selectedPost['excerpt'] : ($blogDescription !== '' ? $blogDescription : 'Blog article page.');
$metaImage       = $selectedPost ? ($selectedPost['thumbnail'] ?? '') : '';
$metaUrl         = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? '')
    . ($_SERVER['REQUEST_URI'] ?? '');
$metaAuthor      = $selectedPost && !empty($selectedPost['author']['name'])
    ? $selectedPost['author']['name']
    : ($site['author_name'] ?? ($site['site_name'] ?? 'AI Law Guide'));
$metaPublished   = $selectedPost ? ($selectedPost['date_iso'] ?? $selectedPost['date'] ?? '') : '';
$metaCategory    = $selectedPost ? ($selectedPost['category'] ?? '') : '';
$metaCategoryUrl = $selectedPost ? ($selectedPost['category_url'] ?? '') : '';
$basePath = rtrim((string) ($site['base_path'] ?? '/'), '/');

/* -- JSON-LD Article Schema ------------------------------------------------ */
$jsonLd = '';
if ($selectedPost !== null) {
    $publisherLogo = (string) ($site['logo'] ?? '');
    if ($publisherLogo === '') {
        $publisherLogo = rtrim((string) ($site['site_url'] ?? ''), '/') . '/favicon.png';
    }

    $schema = [
        '@context'         => 'https://schema.org',
        '@type'            => 'Article',
        'headline'         => $selectedPost['title'],
        'description'      => $metaDescription,
        'image'            => $metaImage,
        'url'              => $metaUrl,
        'datePublished'    => $metaPublished,
        'dateModified'     => $selectedPost['date_modified_iso'] ?? $metaPublished,
        'author'           => [
            '@type' => 'Person',
            'name'  => $metaAuthor,
            'url'   => $selectedPost['author']['url'] ?? '',
        ],
        'publisher'        => [
            '@type' => 'Organization',
            'name'  => $site['site_name'] ?? 'AI Law Guide',
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => $publisherLogo,
            ],
        ],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id'   => $metaUrl,
        ],
    ];
    $jsonLd = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/* Pass extra head tags to header.php via $extraHeadTags */
ob_start();
?>
<!-- Canonical -->
<link rel="canonical" href="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">

<!-- Open Graph -->
<meta property="og:type" content="article">
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">
<?php if ($metaImage !== ''): ?>
    <meta property="og:image" content="<?php echo htmlspecialchars($metaImage, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image:alt" content="<?php echo htmlspecialchars($selectedPost['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
<?php endif; ?>
<?php if ($metaPublished !== ''): ?>
    <meta property="article:published_time" content="<?php echo htmlspecialchars($metaPublished, ENT_QUOTES, 'UTF-8'); ?>">
<?php endif; ?>
<?php if ($metaCategory !== ''): ?>
    <meta property="article:section" content="<?php echo htmlspecialchars($metaCategory, ENT_QUOTES, 'UTF-8'); ?>">
<?php endif; ?>
<meta property="article:author" content="<?php echo htmlspecialchars($metaAuthor, ENT_QUOTES, 'UTF-8'); ?>">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
<?php if ($metaImage !== ''): ?>
    <meta name="twitter:image" content="<?php echo htmlspecialchars($metaImage, ENT_QUOTES, 'UTF-8'); ?>">
<?php endif; ?>

<!-- Standard Meta -->
<meta name="author" content="<?php echo htmlspecialchars($metaAuthor, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="robots" content="index, follow">

<?php if ($jsonLd !== ''): ?>
    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
        <?php echo $jsonLd; ?>
    </script>
<?php endif; ?>
<?php
$extraHeadTags = ob_get_clean();

require __DIR__ . '/includes/header.php';
?>

<section class="grid gap-6 lg:grid-cols-3 lg:gap-8 xl:gap-10">

    <!-- -- Main content ---------------------------------------------------- -->
    <div class="min-w-0 space-y-6 lg:col-span-2">

        <?php if ($selectedPost): ?>

            <!-- Breadcrumb -->
            <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-xs text-slate-500">
                <a href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>" class="hover:text-slate-800 hover:underline">Home</a>
                <span aria-hidden="true">/</span>
                <?php if ($metaCategory !== ''): ?>
                    <a href="<?php echo htmlspecialchars($metaCategoryUrl !== '' ? $metaCategoryUrl : ($basePath . '/category/' . rawurlencode(strtolower(str_replace(' ', '-', $metaCategory)))), ENT_QUOTES, 'UTF-8'); ?>"
                        class="hover:text-slate-800 hover:underline">
                        <?php echo htmlspecialchars($metaCategory, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                    <span aria-hidden="true">/</span>
                <?php endif; ?>
                <span class="truncate font-medium text-slate-700" aria-current="page">
                    <?php echo htmlspecialchars($selectedPost['title'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
            </nav>

            <!-- Article card -->
            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                itemscope itemtype="https://schema.org/Article">

                <div class="p-5 sm:p-7 md:p-8">

                    <!-- Category badge -->
                    <?php if ($metaCategory !== ''): ?>
                        <a class="inline-block rounded-full bg-blue-50 px-3 py-0.5 text-xs font-semibold uppercase tracking-widest text-blue-600 hover:bg-blue-100"
                           href="<?php echo htmlspecialchars($metaCategoryUrl !== '' ? $metaCategoryUrl : ($basePath . '/category/' . rawurlencode(strtolower(str_replace(' ', '-', $metaCategory)))), ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($metaCategory, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    <?php endif; ?>

                    <!-- Title -->
                    <h1 class="mt-3 text-2xl font-bold leading-tight tracking-tight text-slate-900 sm:text-3xl"
                        itemprop="headline">
                        <?php echo htmlspecialchars($selectedPost['title'], ENT_QUOTES, 'UTF-8'); ?>
                    </h1>

                    <!-- Meta row: date + updated + read time -->
                    <?php
                    $metaModified    = (string) ($selectedPost['date_modified_iso'] ?? '');
                    $modifiedTs      = $metaModified !== '' ? strtotime($metaModified) : false;
                    $publishedTs     = $metaPublished !== '' ? strtotime($metaPublished) : false;
                    $showUpdated     = $modifiedTs !== false && $publishedTs !== false && ($modifiedTs - $publishedTs) > 86400;
                    $modifiedFormatted = $modifiedTs !== false ? date('F j, Y', $modifiedTs) : '';
                    ?>
                    <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 sm:text-sm">
                        <time itemprop="datePublished" class="inline-flex items-center gap-1"
                            datetime="<?php echo htmlspecialchars($metaPublished, ENT_QUOTES, 'UTF-8'); ?>">
                            <i class="bi bi-calendar3" aria-hidden="true"></i>
                            <?php echo htmlspecialchars($selectedPost['date'], ENT_QUOTES, 'UTF-8'); ?>
                        </time>
                        <?php if ($showUpdated): ?>
                            <span aria-hidden="true" class="text-slate-300">|</span>
                            <time itemprop="dateModified" class="inline-flex items-center gap-1 text-brand-600"
                                datetime="<?php echo htmlspecialchars($metaModified, ENT_QUOTES, 'UTF-8'); ?>">
                                <i class="bi bi-arrow-clockwise" aria-hidden="true"></i>
                                Updated <?php echo htmlspecialchars($modifiedFormatted, ENT_QUOTES, 'UTF-8'); ?>
                            </time>
                        <?php else: ?>
                            <meta itemprop="dateModified" content="<?php echo htmlspecialchars($metaModified !== '' ? $metaModified : $metaPublished, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php endif; ?>
                        <span aria-hidden="true" class="text-slate-300">|</span>
                        <span class="inline-flex items-center gap-1"><i class="bi bi-clock" aria-hidden="true"></i><?php echo htmlspecialchars($selectedPost['read_time'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>

                    <!-- Author card -->
                    <?php if (!empty($selectedPost['author'])): ?>
                        <div class="mt-6 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3"
                            itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <div class="leading-snug">
                                <p class="text-[11px] uppercase tracking-wide text-slate-500">Written by</p>
                                <p class="text-sm font-semibold text-slate-900 sm:text-base"
                                    itemprop="name">
                                    <?php echo htmlspecialchars($selectedPost['author']['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                            </div>
                            <a class="shrink-0 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-100"
                                href="<?php echo htmlspecialchars($selectedPost['author']['url'], ENT_QUOTES, 'UTF-8'); ?>"
                                itemprop="url">
                                View profile
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Divider -->
                    <hr class="my-6 border-slate-200">

                    <!-- Article body -->
                    <div class="article-content prose prose-slate max-w-none text-sm leading-7 text-slate-700 sm:text-base
                                prose-headings:font-bold prose-headings:tracking-tight
                                prose-a:text-blue-600 prose-a:underline hover:prose-a:text-blue-800
                                prose-img:rounded-xl prose-img:shadow-sm
                                prose-code:rounded prose-code:bg-slate-100 prose-code:px-1 prose-code:py-0.5
                                prose-blockquote:border-l-blue-400 prose-blockquote:bg-slate-50 prose-blockquote:py-1 prose-blockquote:pl-4"
                        itemprop="articleBody">
                        <?php echo $renderedContent; ?>
                    </div>

                    <!-- Share row -->
                    <div class="mt-8 flex flex-wrap items-center gap-2 border-t border-slate-200 pt-6">
                        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Share:</span>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($metaUrl); ?>&text=<?php echo urlencode($selectedPost['title']); ?>"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-50"><i class="bi bi-twitter-x" aria-hidden="true"></i>Twitter</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($metaUrl); ?>"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <i class="bi bi-facebook" aria-hidden="true"></i>Facebook
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($metaUrl); ?>"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <i class="bi bi-linkedin" aria-hidden="true"></i>LinkedIn
                        </a>
                        <button onclick="navigator.clipboard.writeText('<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>').then(()=>this.textContent='Copied!')"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 cursor-pointer">
                            <i class="bi bi-link-45deg" aria-hidden="true"></i>Copy link
                        </button>
                    </div>

                </div>
            </article>

            <!-- Related / suggestions -->
            <?php require __DIR__ . '/includes/suggestions.php'; ?>

        <?php else: ?>

            <!-- Not found state -->
            <div class="rounded-2xl border border-amber-300 bg-amber-50 p-6 sm:p-8">
                <div class="flex items-start gap-3">
                    <i class="bi bi-exclamation-triangle mt-0.5 text-xl text-amber-700" aria-hidden="true"></i>
                    <div>
                        <h1 class="text-lg font-semibold text-amber-900 sm:text-xl">Article not found</h1>
                        <p class="mt-2 text-sm text-amber-800">
                            <strong>Reason:</strong>
                            <?php echo htmlspecialchars($apiError !== '' ? $apiError : 'Unknown API response issue.', ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <p class="mt-1 text-sm text-amber-800">
                            <strong>Post ID:</strong>
                            <?php echo htmlspecialchars($postId !== '' ? $postId : '(empty)', ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <a href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>" class="mt-4 inline-flex items-center gap-1 rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-amber-700 transition"><i class="bi bi-arrow-left" aria-hidden="true"></i>Back to home</a>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>

    <!-- -- Sidebar ---------------------------------------------------------- -->
    <aside class="space-y-6 lg:col-span-1">
        <?php require __DIR__ . '/includes/sidebar.php'; ?>
    </aside>

</section>

<?php require __DIR__ . '/includes/footer.php'; ?>




