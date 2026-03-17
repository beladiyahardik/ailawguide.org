<?php
require_once __DIR__ . '/blogger.php';
if (!isset($posts) || !is_array($posts)) {
    $posts = blogger_fetch_posts($site, 9);
}
$currentPostId = '';
$currentCategorySlug = '';
if (isset($selectedPost) && is_array($selectedPost)) {
    $currentPostId = (string) ($selectedPost['id'] ?? '');
    $currentCategorySlug = (string) ($selectedPost['category_slug'] ?? '');
}
$basePath = rtrim((string) ($site['base_path'] ?? '/'), '/');
$defaultAuthorName = (string) ($site['author_name'] ?? 'Rahul Beladiya');
$defaultAuthorKey = blogger_normalize_author_key($defaultAuthorName);
$featuredAuthor = [
    'name' => $defaultAuthorName,
    'key' => $defaultAuthorKey,
    'url' => $basePath . '/author/' . rawurlencode($defaultAuthorKey),
];
foreach ($posts as $post) {
    if (!empty($post['author']['name'])) {
        $featuredAuthor = $post['author'];
        break;
    }
}
$featuredAuthorKey = (string) ($featuredAuthor['key'] ?? $defaultAuthorKey);
$featuredAuthorUrl = (string) ($featuredAuthor['url'] ?? ($basePath . '/author/' . rawurlencode($featuredAuthorKey)));
$featuredAuthorName = (string) ($featuredAuthor['name'] ?? $defaultAuthorName);
$sidebarSuggestions = blogger_select_related_posts($posts, $currentPostId, $currentCategorySlug, 4);
?>
<aside class="space-y-5 sm:space-y-6">
    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">About this blog</h2>
        <p class="mt-3 text-sm leading-7 text-slate-600"><?php echo htmlspecialchars($site['tagline'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p class="mt-2 text-sm leading-7 text-slate-600">Clear, implementation-focused guidance for founders, developers, and teams working on real AI products.</p>
    </section>

    <section class="ad-wrap hidden rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5 lg:block">
        <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-700">Sponsored</h2>
        <div class="ad-slot mt-3 flex h-[600px] items-center justify-center rounded-xl text-[11px] font-semibold uppercase tracking-[0.28em] text-slate-500">
            Display Ad Placeholder
        </div>
    </section>

    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">About the Author</h2>
        <div class="mt-3 rounded-xl border border-slate-200 bg-slate-50 p-3">
            <div class="min-w-0">
                <p class="text-base font-semibold leading-tight text-slate-900"><?php echo htmlspecialchars($featuredAuthorName, ENT_QUOTES, 'UTF-8'); ?></p>
                <p class="mt-1 text-xs text-slate-500">AI developer and regulatory researcher</p>
            </div>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                I am an AI developer dedicated to exploring the intersection of technology and global regulation. While not a legal professional, I track and analyze AI laws and governance across different countries to provide developer-centric insights into the evolving landscape of AI law news.
            </p>
            <a class="mt-3 inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-100" href="<?php echo htmlspecialchars($featuredAuthorUrl, ENT_QUOTES, 'UTF-8'); ?>">
                View full profile
            </a>
        </div>
    </section>

    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Categories</h2>
        <ul class="mt-3 grid grid-cols-1 gap-2 text-sm text-slate-600 sm:grid-cols-2 lg:grid-cols-1">
            <?php
            $categories = [];
            foreach ($posts as $post) {
                $categoryName = (string) ($post['category'] ?? 'General');
                $categorySlug = (string) ($post['category_slug'] ?? blogger_normalize_category_slug($categoryName));
                $categories[$categorySlug] = $categoryName;
            }
            asort($categories);
            ?>
            <?php foreach ($categories as $slug => $category): ?>
                <li>
                    <a class="block rounded bg-slate-50 px-2 py-1 hover:bg-slate-100"
                       href="<?php echo htmlspecialchars($basePath . '/category/' . rawurlencode($slug), ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Suggested Reads</h2>
        <?php if (!empty($sidebarSuggestions)): ?>
            <ul class="mt-3 space-y-3 text-sm">
                <?php foreach ($sidebarSuggestions as $post): ?>
                    <li class="flex items-start gap-3">
                        <?php if (!empty($post['thumbnail'])): ?>
                            <img class="h-12 w-16 flex-shrink-0 rounded bg-slate-100 object-contain" src="<?php echo htmlspecialchars($post['thumbnail'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?> thumbnail" loading="lazy">
                        <?php endif; ?>
                        <div>
                            <a class="font-medium leading-6 text-slate-800 hover:text-slate-950" href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></a>
                            <p class="mt-1 text-xs text-slate-500"><?php echo htmlspecialchars($post['read_time'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Quick Start</h2>
        <ul class="mt-3 space-y-2 text-sm text-slate-600">
            <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/about', ENT_QUOTES, 'UTF-8'); ?>">About this publication</a></li>
            <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/contact', ENT_QUOTES, 'UTF-8'); ?>">Editorial contact</a></li>
            <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/privacy-policy', ENT_QUOTES, 'UTF-8'); ?>">Privacy commitment</a></li>
            <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/author/' . rawurlencode($featuredAuthorKey), ENT_QUOTES, 'UTF-8'); ?>">Meet our author</a></li>
        </ul>
    </section>

    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Newsletter</h2>
        <p class="mt-2 text-sm text-slate-600">Get new practical guides in your inbox.</p>
        <form class="mt-3 space-y-2" method="post" action="#">
            <input class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm" type="email" placeholder="you@example.com" aria-label="Email address">
            <button class="w-full rounded-md bg-slate-900 px-3 py-2 text-sm text-white hover:bg-slate-700" type="button">Subscribe</button>
        </form>
    </section>

</aside>
