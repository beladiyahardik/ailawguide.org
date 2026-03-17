<?php
require_once __DIR__ . '/includes/blogger.php';

$site = require __DIR__ . '/includes/site.php';
$pageTitle       = 'AI Law Guide: Global Compliance, EU AI Act & Legal Audits';
$metaDescription = blogger_blog_description(
    $site,
    'Master AI legal compliance. Expert guides on the EU AI Act, US state laws, and bias audits. Get actionable checklists to protect your business in 2026.'
);

/* -- SEO / Meta ------------------------------------------------------------ */
$metaUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? '')
    . '/';
$metaImage = ''; // Set to your default OG image URL, e.g. '/assets/og-default.jpg'

/* -- Extra <head> tags injected into header.php via $extraHeadTags ---------- */
ob_start();
?>
<!-- Canonical -->
<link rel="canonical" href="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">
<?php if ($metaImage !== ''): ?>
    <meta property="og:image" content="<?php echo htmlspecialchars($metaImage, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image:alt" content="AI Law Guide Blog">
<?php endif; ?>

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
<?php if ($metaImage !== ''): ?>
    <meta name="twitter:image" content="<?php echo htmlspecialchars($metaImage, ENT_QUOTES, 'UTF-8'); ?>">
<?php endif; ?>

<!-- Standard Meta -->
<meta name="robots" content="index, follow">
<meta name="author" content="<?php echo htmlspecialchars($site['author_name'] ?? ($site['site_name'] ?? 'AI Law Guide'), ENT_QUOTES, 'UTF-8'); ?>">

<!-- JSON-LD: WebSite + Sitelinks Searchbox -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "AI Law Guide",
        "url": "<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>",
        "description": "<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>search?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
</script>
<?php
$extraHeadTags = ob_get_clean();

require __DIR__ . '/includes/header.php';

$posts    = blogger_fetch_posts($site, 100);
$apiError = blogger_last_error();
?>

<section class="grid gap-6 lg:grid-cols-3 lg:gap-8 xl:gap-10">

    <!-- -- Main content ---------------------------------------------------- -->
    <div class="min-w-0 space-y-5 sm:space-y-6 lg:col-span-2">

        <!-- Hero / intro -->
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
            <span class="inline-block rounded-full bg-blue-50 px-3 py-0.5 text-xs font-semibold uppercase tracking-widest text-blue-600">
                Independent publication
            </span>
            <h1 class="mt-3 text-2xl font-bold leading-tight tracking-tight text-slate-900 sm:text-3xl">
                Practical tutorials on AI law, web, business, and technology.
            </h1>
            <p class="mt-3 text-sm leading-7 text-slate-600 sm:text-base">
                AI Law Guide helps founders, developers, and teams understand AI compliance without legal confusion.
                We publish practical, plain-language guides on regulations, privacy, governance, and real implementation steps.
            </p>
        </section>

        <!-- Post list -->
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                    <div class="blog-list-card">

                        <!-- Thumbnail -->
                        <?php if (!empty($post['thumbnail'])): ?>
                            <a class="blog-list-thumb relative block"
                                href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>"
                                tabindex="-1" aria-hidden="true">
                                <img class="blog-list-img"
                                    src="<?php echo htmlspecialchars($post['thumbnail'], ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?> thumbnail"
                                    loading="lazy" width="208" height="160">
                            </a>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="blog-list-body gap-3 p-4 sm:p-5">
                            <div>
                                <!-- Category -->
                                <?php if (!empty($post['category'])): ?>
                                    <a class="inline-block rounded-full bg-blue-50 px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-widest text-blue-600 hover:bg-blue-100"
                                        href="<?php echo htmlspecialchars($post['category_url'] ?? '#', ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                <?php endif; ?>

                                <!-- Title -->
                                <h2 class="mt-2 text-base font-semibold leading-snug text-slate-900 sm:text-lg">
                                    <a class="hover:underline decoration-blue-400 underline-offset-2"
                                        href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </h2>

                                <!-- Excerpt hidden on very small screens -->
                                <p class="mt-1.5 hidden text-sm leading-6 text-slate-600 sm:line-clamp-2 sm:block">
                                    <?php echo htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                            </div>

                            <!-- Footer meta -->
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-slate-500 sm:text-sm">
                                <time class="inline-flex items-center gap-1"><i class="bi bi-calendar3" aria-hidden="true"></i><?php echo htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?></time>
                                <span aria-hidden="true" class="text-slate-300">|</span>
                                <span class="inline-flex items-center gap-1"><i class="bi bi-clock" aria-hidden="true"></i><?php echo htmlspecialchars($post['read_time'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        </div>

                    </div>
                </article>
            <?php endforeach; ?>

        <?php else: ?>
            <!-- API error state -->
            <div class="rounded-2xl border border-amber-300 bg-amber-50 p-5 sm:p-6">
                <div class="flex items-start gap-3">
                    <i class="bi bi-exclamation-triangle mt-0.5 text-xl text-amber-700" aria-hidden="true"></i>
                    <div>
                        <h2 class="text-lg font-semibold text-amber-900 sm:text-xl">No posts loaded from Blogger API</h2>
                        <p class="mt-2 text-sm text-amber-800">
                            <strong>Reason:</strong>
                            <?php echo htmlspecialchars($apiError !== '' ? $apiError : 'Unknown API response issue.', ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <p class="mt-2 text-sm text-amber-800">
                            If your API key is HTTP-referrer restricted, server-side PHP calls may be blocked.
                            Use an unrestricted key for server-side requests, or apply IP restrictions instead.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php require __DIR__ . '/includes/suggestions.php'; ?>
    </div>

    <!-- -- Sidebar ---------------------------------------------------------- -->
    <aside class="space-y-6 lg:col-span-1">
        <?php require __DIR__ . '/includes/sidebar.php'; ?>
    </aside>

</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
