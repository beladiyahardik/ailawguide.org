<?php
$site = require __DIR__ . '/includes/site.php';
require __DIR__ . '/includes/blogger.php';

$authorKey = (string) ($_GET['author'] ?? '');
$defaultAuthorKey = blogger_normalize_author_key((string) ($site['author_slug'] ?? ($site['author_name'] ?? 'Rahul Beladiya')));
$requestPath = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
if ($authorKey === '') {
    if ($requestPath !== '' && preg_match('#/author/([^/]+)/?$#', $requestPath, $matches)) {
        $authorKey = (string) $matches[1];
    }
}

$authorKey   = blogger_normalize_author_key($authorKey);
if ($authorKey === '' || $authorKey !== $defaultAuthorKey) {
    $authorKey = $defaultAuthorKey;
}
$posts       = blogger_fetch_posts($site, 100);
$author      = blogger_find_author($posts, $authorKey);
$authorPosts = blogger_filter_posts_by_author($posts, $authorKey);

$resolvedName  = $author['name'] ?? $site['author_name'] ?? 'Rahul Beladiya';
$resolvedTitle = $site['author_title'] ?? 'Provides guidance on AI adoption within legal frameworks.';
$resolvedBio   = $site['author_bio'] ?? '';
$basePath      = rtrim((string) ($site['base_path'] ?? '/'), '/');
$authorPath    = (string) ($site['author_profile_path'] ?? (($basePath === '' ? '' : $basePath) . '/author/' . rawurlencode($authorKey)));
$metaUrl       = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? '') . $authorPath;

$isCanonicalAuthorPath = $requestPath !== '' && preg_match('#^' . preg_quote($authorPath, '#') . '/?$#', $requestPath);
$needsAuthorRedirect = $requestPath === ''
    || preg_match('#/author/?$#', $requestPath)
    || !$isCanonicalAuthorPath;

if ($needsAuthorRedirect) {
    header('Location: ' . $authorPath, true, 301);
    exit;
}

$pageTitle       = $resolvedName . ' | Author | AI Law Guide';
$metaDescription = 'Learn about ' . $resolvedName . ', a legal tech strategist and writer covering AI, legal technology, and digital transformation. Read ' . count($authorPosts) . ' published articles on AI law and legal operations.';

ob_start();
?>
<link rel="canonical" href="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:type" content="profile">
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:site_name" content="AI Law Guide">
<meta name="robots" content="index, follow">
<meta name="author" content="<?php echo htmlspecialchars($resolvedName, ENT_QUOTES, 'UTF-8'); ?>">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ProfilePage",
  "url": "<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>",
  "name": "<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>",
  "mainEntity": {
    "@type": "Person",
    "name": "<?php echo htmlspecialchars($resolvedName, ENT_QUOTES, 'UTF-8'); ?>",
    "jobTitle": "<?php echo htmlspecialchars($resolvedTitle, ENT_QUOTES, 'UTF-8'); ?>",
    "description": "<?php echo htmlspecialchars($resolvedBio, ENT_QUOTES, 'UTF-8'); ?>",
    "url": "<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>",
    "sameAs": [
      "https://github.com/rcbeladiya"
    ],
    "knowsAbout": [
      "Legal Technology",
      "Artificial Intelligence",
      "Contract Lifecycle Management",
      "Legal Operations",
      "Compliance Technology",
      "Digital Transformation"
    ],
    "worksFor": {
      "@type": "Organization",
      "name": "AI Law Guide",
      "url": "<?php echo htmlspecialchars((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
    }
  }
}
</script>
<?php
$extraHeadTags = ob_get_clean();
require __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumb -->
<nav class="mb-5 flex items-center gap-2 text-sm text-slate-500" aria-label="Breadcrumb">
    <a href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>" class="hover:text-slate-900">Home</a>
    <span aria-hidden="true" class="text-slate-300">/</span>
    <span class="font-medium text-slate-700" aria-current="page">Author</span>
</nav>

<section class="grid gap-6 lg:grid-cols-3 lg:gap-8">
    <div class="space-y-5 sm:space-y-6 lg:col-span-2">

        <?php if ($author || $authorKey !== ''): ?>
        <!-- Author profile card -->
        <section class="rounded-2xl border border-brand-200 bg-brand-50 p-6 shadow-sm sm:p-7" itemscope itemtype="https://schema.org/Person">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-brand-600 text-2xl font-bold text-white shadow-md">
                    <?php echo strtoupper(substr($resolvedName, 0, 1)); ?>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">Author</p>
                    <h1 class="mt-1 text-2xl font-bold text-slate-900" itemprop="name">
                        <?php echo htmlspecialchars($resolvedName, ENT_QUOTES, 'UTF-8'); ?>
                    </h1>
                    <p class="mt-0.5 text-sm font-medium text-slate-600" itemprop="jobTitle">
                        <?php echo htmlspecialchars($resolvedTitle, ENT_QUOTES, 'UTF-8'); ?>
                    </p>

                    <?php if ($resolvedBio !== ''): ?>
                        <p class="mt-3 text-sm leading-7 text-slate-700" itemprop="description">
                            <?php echo htmlspecialchars($resolvedBio, ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    <?php else: ?>
                        <p class="mt-3 text-sm leading-7 text-slate-700">
                            I am a Legal Tech strategist and writer focused on the intersection of law, AI, and digital transformation. My work helps legal teams and technology companies make practical decisions about legal tech, compliance workflows, and technology-enabled operations.
                        </p>
                    <?php endif; ?>

                    <!-- Expertise tags -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <?php
                        $expertise = ['Legal Technology', 'AI in Legal Workflows', 'Contract Lifecycle Management', 'Legal Operations', 'Compliance Strategy', 'Digital Empowerment'];
                        foreach ($expertise as $tag):
                        ?>
                            <span class="rounded-full border border-brand-200 bg-white px-3 py-1 text-xs font-medium text-brand-700">
                                <?php echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>

                    <!-- Links -->
                    <div class="mt-4 flex flex-wrap gap-3">
                        <?php if (!empty($site['author_github'])): ?>
                            <a href="<?php echo htmlspecialchars($site['author_github'], ENT_QUOTES, 'UTF-8'); ?>"
                               rel="noopener noreferrer" target="_blank"
                               class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                                <i class="bi bi-github" aria-hidden="true"></i> GitHub
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo htmlspecialchars($basePath . '/contact', ENT_QUOTES, 'UTF-8'); ?>"
                           class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <i class="bi bi-envelope" aria-hidden="true"></i> Contact
                        </a>
                        <a href="<?php echo htmlspecialchars($basePath . '/about', ENT_QUOTES, 'UTF-8'); ?>"
                           class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <i class="bi bi-info-circle" aria-hidden="true"></i> About This Site
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Not legal advice note -->
        <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-5 py-4">
            <i class="bi bi-info-circle mt-0.5 shrink-0 text-lg text-amber-600" aria-hidden="true"></i>
            <p class="text-sm leading-6 text-amber-800">
                <strong>Educational content only.</strong> This page shares strategic and informational insights on AI, legal technology, and digital transformation. For legal advice or jurisdiction-specific decisions, consult qualified legal counsel.
            </p>
        </div>

        <!-- What I focus on -->
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Focus Areas</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <?php
                $focusAreas = [
                    ['bi-cpu', 'AI-Powered Contract Lifecycle Management', 'Practical guidance on evaluating and implementing AI-driven CLM systems that improve drafting, review, and approval workflows.'],
                    ['bi-briefcase', 'Future-Ready Legal Operations', 'Strategies for building legal operations that are scalable, technology-enabled, and aligned with business growth.'],
                    ['bi-shield-check', 'Compliance and Efficiency', 'Support in choosing tools and workflows that strengthen compliance while improving the efficiency of legal and business teams.'],
                    ['bi-diagram-3', 'Legal Tech Ecosystem Navigation', 'Clear analysis of vendors, platforms, and categories across the legal tech landscape to support smarter technology decisions.'],
                    ['bi-gear', 'Digital Transformation for Legal Teams', 'Actionable approaches for modernizing legal work through automation, process design, and better digital support.'],
                    ['bi-lightbulb', 'Practical Technology Strategy', 'Complex innovations translated into grounded, useful strategies that legal professionals and tech leaders can apply with confidence.'],
                ];
                foreach ($focusAreas as [$icon, $title, $desc]):
                ?>
                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                        <i class="bi <?php echo $icon; ?> text-xl text-brand-600" aria-hidden="true"></i>
                        <p class="mt-2 text-sm font-semibold text-slate-900"><?php echo $title; ?></p>
                        <p class="mt-1 text-xs leading-5 text-slate-600"><?php echo $desc; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Articles by this author -->
        <?php if (!empty($authorPosts)): ?>
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-slate-900 sm:text-xl">
                    Articles by <?php echo htmlspecialchars($resolvedName, ENT_QUOTES, 'UTF-8'); ?>
                </h2>
                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600">
                    <?php echo count($authorPosts); ?> published
                </span>
            </div>
            <div class="mt-5 space-y-4">
                <?php foreach ($authorPosts as $post): ?>
                    <article class="group rounded-xl border border-slate-100 bg-slate-50 p-4 transition hover:border-slate-200 hover:bg-white hover:shadow-sm">
                        <a class="text-base font-semibold text-slate-800 hover:text-brand-600 hover:underline underline-offset-2"
                           href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                        <?php if (!empty($post['excerpt'])): ?>
                            <p class="mt-1.5 text-sm leading-6 text-slate-600 line-clamp-2">
                                <?php echo htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                        <?php endif; ?>
                        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500">
                            <?php if (!empty($post['date'])): ?>
                                <time><i class="bi bi-calendar3 mr-1" aria-hidden="true"></i><?php echo htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?></time>
                            <?php endif; ?>
                            <?php if (!empty($post['read_time'])): ?>
                                <span><i class="bi bi-clock mr-1" aria-hidden="true"></i><?php echo htmlspecialchars($post['read_time'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($post['category'])): ?>
                                <span class="rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-blue-600">
                                    <?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php elseif ($author): ?>
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Articles</h2>
            <p class="mt-2 text-sm text-slate-600">No published articles found for this author yet.</p>
        </section>
        <?php endif; ?>

        <?php else: ?>
        <section class="rounded-2xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
            <h1 class="text-lg font-semibold text-amber-900">Author not found</h1>
            <p class="mt-2 text-sm text-amber-800">No author profile matched this URL. <a class="underline" href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>">Return to home</a>.</p>
        </section>
        <?php endif; ?>

    </div>

    <?php require __DIR__ . '/includes/sidebar.php'; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
