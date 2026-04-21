<?php
require __DIR__ . '/includes/page-cache.php';
$pageTitle = 'Post Template | AI Law Guide';
$metaDescription = 'Sample post template showcasing editorial layout and author attribution.';
$metaRobots = 'noindex, nofollow';
require __DIR__ . '/includes/header.php';
?>

<section class="grid gap-6 lg:grid-cols-3 lg:gap-8 xl:gap-10">
    <article class="min-w-0 space-y-6 lg:col-span-2" itemscope itemtype="https://schema.org/Article">
        <header class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
            <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-slate-500">Editorial Brief</p>
            <h1 class="mt-3 text-2xl font-bold leading-tight tracking-tight text-slate-900 sm:text-3xl" itemprop="headline">
                What the EU AI Act Means for Product Teams in 2026
            </h1>
            <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 sm:text-sm">
                <time datetime="2026-03-13" itemprop="datePublished">March 13, 2026</time>
                <span aria-hidden="true" class="text-slate-300">|</span>
                <span>8 min read</span>
            </div>
        </header>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
            <div class="article-content prose prose-slate max-w-none text-sm leading-7 text-slate-700 sm:text-base" itemprop="articleBody">
                <p>AI regulation has moved from policy conversations to operational requirements. The EU AI Act introduces concrete expectations for documentation, risk classification, and governance workflows that product teams must implement early.</p>
                <p>For engineering leaders, the practical shift is clear: compliance is now a build requirement. That means mapping systems to risk tiers, establishing evidence trails, and aligning release gates with regulatory obligations.</p>
                <p>This template demonstrates the editorial layout used across AI Law Guide. Maintain a strong text-to-image ratio and clear headings to help readers scan long-form content. The layout should feel like a professional publication.</p>
                <p>Use clear headings, short paragraphs, and structured lists to help readers navigate complex regulatory topics efficiently.</p>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7" aria-label="About the author">
            <h2 class="text-lg font-semibold text-slate-900">About the Author</h2>
            <p class="mt-1 text-sm font-semibold text-slate-900">
                <?php echo htmlspecialchars($site['author_name'] ?? 'Rahul Beladiya', ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <p class="mt-2 text-sm leading-7 text-slate-600">
                <?php echo htmlspecialchars($site['author_bio'] ?? 'AI developer tracking global AI regulation to help engineering and product teams build compliant systems.', ENT_QUOTES, 'UTF-8'); ?>
            </p>
        </section>
    </article>

    <aside class="space-y-6 lg:col-span-1">
        <?php require __DIR__ . '/includes/sidebar.php'; ?>
    </aside>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
