<?php
require __DIR__ . '/includes/page-cache.php';
require_once __DIR__ . '/includes/blogger.php';

$site = require __DIR__ . '/includes/site.php';
$pageTitle       = 'AI Law Guide: Practical AI Compliance, EU AI Act & Regulatory Guides';
$metaDescription = blogger_blog_description(
    $site,
    'Plain-language guides on AI regulation, EU AI Act compliance, US state AI laws, and model risk management for founders, developers, and product teams.'
);

$metaUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? '') . '/';

ob_start();
?>
<!-- Canonical -->
<link rel="canonical" href="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">

<!-- Open Graph -->
<meta property="og:type"        content="website">
<meta property="og:title"       content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url"         content="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:site_name"   content="AI Law Guide">

<!-- Twitter Card -->
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">

<!-- Standard Meta -->
<meta name="robots" content="index, follow">
<meta name="author" content="Rahul Beladiya">

<!-- JSON-LD: WebSite + Sitelinks Searchbox -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebSite",
      "name": "AI Law Guide",
      "url": "<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>",
      "description": "<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>",
      "inLanguage": "en-US",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>search?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    },
    {
      "@type": "Organization",
      "name": "AI Law Guide",
      "url": "<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>",
      "description": "<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>",
      "founder": {
        "@type": "Person",
        "name": "Rahul Beladiya",
        "jobTitle": "AI Developer & Regulatory Researcher"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "email": "<?php echo htmlspecialchars($site['contact_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>",
        "contactType": "editorial"
      }
    }
  ]
}
</script>
<?php
$extraHeadTags = ob_get_clean();
require __DIR__ . '/includes/header.php';

$posts    = blogger_fetch_posts($site, 100);
$apiError = blogger_last_error();
$basePath = rtrim((string) ($site['base_path'] ?? '/'), '/');
?>

<section class="grid gap-6 lg:grid-cols-3 lg:gap-8 xl:gap-10">

    <!-- Main content -->
    <div class="min-w-0 space-y-5 sm:space-y-6 lg:col-span-2">

        <!-- Hero / intro -->
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <span class="inline-block rounded-full bg-brand-50 px-3 py-0.5 text-xs font-semibold uppercase tracking-widest text-brand-600">
                Independent publication
            </span>
            <h1 class="mt-3 text-2xl font-bold leading-tight tracking-tight text-slate-900 sm:text-3xl">
                AI Law & Compliance Guides for Builders
            </h1>
            <p class="mt-3 text-sm leading-7 text-slate-600 sm:text-base">
                Plain-language guides on AI regulation, EU AI Act compliance, US state AI laws, and model risk management. Written by an AI developer for founders, engineers, and product teams who need to understand the rules without the legal jargon.
            </p>
            <!-- Credibility signals -->
            <div class="mt-5 flex flex-wrap gap-x-4 gap-y-2 text-xs text-slate-500">
                <span class="flex items-center gap-1.5"><i class="bi bi-person-check text-brand-500" aria-hidden="true"></i> Written by a practitioner</span>
                <span class="flex items-center gap-1.5"><i class="bi bi-file-earmark-text text-brand-500" aria-hidden="true"></i> Primary source research</span>
                <span class="flex items-center gap-1.5"><i class="bi bi-patch-check text-brand-500" aria-hidden="true"></i> Updated as regulations evolve</span>
                <span class="flex items-center gap-1.5"><i class="bi bi-shield-x text-slate-400" aria-hidden="true"></i> Not legal advice</span>
            </div>
        </section>

        <!-- Post list -->
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $i => $post): ?>
                <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md" itemscope itemtype="https://schema.org/Article">
                    <div class="blog-list-card">

                        <!-- Thumbnail -->
                        <?php if (!empty($post['thumbnail'])): ?>
                            <a class="blog-list-thumb relative block"
                               href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>"
                               tabindex="-1" aria-hidden="true">
                                <img class="blog-list-img"
                                     src="<?php echo htmlspecialchars($post['thumbnail'], ENT_QUOTES, 'UTF-8'); ?>"
                                     alt="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>"
                                     loading="<?php echo $i < 3 ? 'eager' : 'lazy'; ?>"
                                     width="208" height="160" itemprop="image">
                            </a>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="blog-list-body gap-3 p-4 sm:p-5">
                            <div>
                                <!-- Category -->
                                <?php if (!empty($post['category'])): ?>
                                    <a class="inline-block rounded-full bg-blue-50 px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-widest text-blue-600 hover:bg-blue-100"
                                       href="<?php echo htmlspecialchars($post['category_url'] ?? '#', ENT_QUOTES, 'UTF-8'); ?>"
                                       itemprop="articleSection">
                                        <?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                <?php endif; ?>

                                <!-- Title -->
                                <h2 class="mt-2 text-base font-semibold leading-snug text-slate-900 sm:text-lg" itemprop="headline">
                                    <a class="hover:underline decoration-brand-400 underline-offset-2"
                                       href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>"
                                       itemprop="url">
                                        <?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </h2>

                                <!-- Excerpt -->
                                <p class="mt-1.5 hidden text-sm leading-6 text-slate-600 sm:line-clamp-2 sm:block" itemprop="description">
                                    <?php echo htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                            </div>

                            <!-- Footer meta -->
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 sm:text-sm">
                                <?php if (!empty($post['date'])): ?>
                                    <time class="inline-flex items-center gap-1"
                                          datetime="<?php echo htmlspecialchars($post['date_iso'] ?? $post['date'], ENT_QUOTES, 'UTF-8'); ?>"
                                          itemprop="datePublished">
                                        <i class="bi bi-calendar3" aria-hidden="true"></i>
                                        <?php echo htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?>
                                    </time>
                                    <span aria-hidden="true" class="text-slate-300">|</span>
                                <?php endif; ?>
                                <span class="inline-flex items-center gap-1">
                                    <i class="bi bi-clock" aria-hidden="true"></i>
                                    <?php echo htmlspecialchars($post['read_time'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                                <?php if (!empty($post['author']['name'])): ?>
                                    <span aria-hidden="true" class="text-slate-300">|</span>
                                    <span class="inline-flex items-center gap-1" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                        <i class="bi bi-person" aria-hidden="true"></i>
                                        <span itemprop="name"><?php echo htmlspecialchars($post['author']['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>

            <?php endforeach; ?>

        <?php else: ?>
            <!-- API error / no posts -->
            <div class="rounded-2xl border border-amber-300 bg-amber-50 p-5 sm:p-6">
                <div class="flex items-start gap-3">
                    <i class="bi bi-exclamation-triangle mt-0.5 text-xl text-amber-700" aria-hidden="true"></i>
                    <div>
                        <h2 class="text-lg font-semibold text-amber-900">Articles are loading</h2>
                        <p class="mt-2 text-sm text-amber-800">
                            <?php if ($apiError !== ''): ?>
                                <strong>Detail:</strong> <?php echo htmlspecialchars($apiError, ENT_QUOTES, 'UTF-8'); ?>
                            <?php else: ?>
                                Content is being fetched. Please refresh in a moment.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php require __DIR__ . '/includes/suggestions.php'; ?>
    </div>

    <!-- Sidebar -->
    <aside class="space-y-6 lg:col-span-1">
        <?php require __DIR__ . '/includes/sidebar.php'; ?>
    </aside>

</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
