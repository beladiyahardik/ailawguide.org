<?php
$pageTitle = 'Post Template | AI Law Guide';
$metaDescription = 'Sample post template showcasing ad placeholders, editorial layout, and author attribution.';
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

        <div class="ad-wrap lg:hidden">
            <div class="ad-slot flex h-40 items-center justify-center rounded-xl text-[11px] font-semibold uppercase tracking-[0.28em] text-slate-500">
                Display Ad Placeholder
            </div>
        </div>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
            <div class="article-content prose prose-slate max-w-none text-sm leading-7 text-slate-700 sm:text-base" itemprop="articleBody">
                <p>AI regulation has moved from policy conversations to operational requirements. The EU AI Act introduces concrete expectations for documentation, risk classification, and governance workflows that product teams must implement early.</p>
                <p>For engineering leaders, the practical shift is clear: compliance is now a build requirement. That means mapping systems to risk tiers, establishing evidence trails, and aligning release gates with regulatory obligations.</p>

                <div class="my-6 ad-wrap">
                    <div class="ad-slot flex h-28 items-center justify-center rounded-xl text-[11px] font-semibold uppercase tracking-[0.28em] text-slate-500">
                        In-Article Ad Placeholder
                    </div>
                </div>

                <p>This template demonstrates how to keep advertising placements visible without overwhelming the reading experience. Maintain a strong text-to-image ratio and place ads only where they make editorial sense.</p>
                <p>Use clear headings, short paragraphs, and structured lists to help readers scan long-form content. The layout should feel like a professional publication rather than a generic landing page.</p>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7" aria-label="About the author">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg font-semibold text-slate-600">
                    AL
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">About the Author</h2>
                    <p class="mt-2 text-sm leading-7 text-slate-600">
                        I am an AI developer dedicated to exploring the intersection of technology and global regulation. While not a legal professional, I track and analyze AI laws and governance across different countries to provide developer-centric insights into the evolving landscape of AI law news.
                    </p>
                </div>
            </div>
        </section>
    </article>

    <aside class="space-y-6 lg:col-span-1">
        <section class="ad-wrap hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:block">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-700">Sponsored</h2>
            <div class="ad-slot mt-3 flex h-[600px] items-center justify-center rounded-xl text-[11px] font-semibold uppercase tracking-[0.28em] text-slate-500">
                Display Ad Placeholder
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-700">Publication Notes</h2>
            <p class="mt-3 text-sm leading-7 text-slate-600">
                This template keeps ads clearly labeled, preserves whitespace, and maintains a magazine-style rhythm for long-form posts.
            </p>
        </section>
    </aside>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
