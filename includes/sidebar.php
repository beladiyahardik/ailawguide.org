<?php
require_once __DIR__ . '/blogger.php';
if (!isset($posts) || !is_array($posts)) {
    $posts = blogger_fetch_posts($site, 9);
}
$currentPostId       = '';
$currentCategorySlug = '';
if (isset($selectedPost) && is_array($selectedPost)) {
    $currentPostId       = (string) ($selectedPost['id']            ?? '');
    $currentCategorySlug = (string) ($selectedPost['category_slug'] ?? '');
}
$basePath          = rtrim((string) ($site['base_path'] ?? '/'), '/');
$defaultAuthorName = (string) ($site['author_name']  ?? 'Rahul Beladiya');
$defaultAuthorKey  = blogger_normalize_author_key($defaultAuthorName);
$featuredAuthor    = [
    'name' => $defaultAuthorName,
    'key'  => $defaultAuthorKey,
    'url'  => $basePath . '/author/' . rawurlencode($defaultAuthorKey),
];
foreach ($posts as $post) {
    if (!empty($post['author']['name'])) {
        $featuredAuthor = $post['author'];
        break;
    }
}
$featuredAuthorKey  = (string) ($featuredAuthor['key'] ?? $defaultAuthorKey);
$featuredAuthorUrl  = (string) ($featuredAuthor['url'] ?? ($basePath . '/author/' . rawurlencode($featuredAuthorKey)));
$featuredAuthorName = (string) ($featuredAuthor['name'] ?? $defaultAuthorName);
$authorTitle        = (string) ($site['author_title'] ?? 'AI Developer & Regulatory Researcher');
$authorBio          = (string) ($site['author_bio']   ?? '');
$sidebarSuggestions = blogger_select_related_posts($posts, $currentPostId, $currentCategorySlug, 4);
?>
<aside class="space-y-5 sm:space-y-6">

    <!-- About the blog -->
    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-500">About This Blog</h2>
        <p class="mt-3 text-sm leading-7 text-slate-700">
            Practical, plain-language guides on AI law, compliance, and governance. Written for founders, developers, and product teams who need to understand regulation without the legal jargon.
        </p>
        <a class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:underline"
           href="<?php echo htmlspecialchars($basePath . '/about', ENT_QUOTES, 'UTF-8'); ?>">
            Learn about this publication <i class="bi bi-arrow-right" aria-hidden="true"></i>
        </a>
    </section>

    <!-- About the Author -->
    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-500">About the Author</h2>
        <div class="mt-3 rounded-xl border border-slate-100 bg-slate-50 p-3">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-600 text-sm font-bold text-white">
                    <?php echo strtoupper(substr($featuredAuthorName, 0, 1)); ?>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold leading-tight text-slate-900">
                        <?php echo htmlspecialchars($featuredAuthorName, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <p class="text-xs text-slate-500">
                        <?php echo htmlspecialchars($authorTitle, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                </div>
            </div>
            <p class="mt-3 text-xs leading-5 text-slate-600">
                <?php if ($authorBio !== ''): ?>
                    <?php echo htmlspecialchars(mb_substr($authorBio, 0, 160) . (mb_strlen($authorBio) > 160 ? '...' : ''), ENT_QUOTES, 'UTF-8'); ?>
                <?php else: ?>
                    AI developer tracking global AI regulation and compliance requirements to help engineering teams build responsible products.
                <?php endif; ?>
            </p>
            <a class="mt-3 inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition hover:bg-slate-100"
               href="<?php echo htmlspecialchars($featuredAuthorUrl, ENT_QUOTES, 'UTF-8'); ?>">
                <i class="bi bi-person-circle" aria-hidden="true"></i> View full profile
            </a>
        </div>
    </section>

    <!-- Categories -->
    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-500">Browse by Topic</h2>
        <ul class="mt-3 grid grid-cols-1 gap-1.5 text-sm sm:grid-cols-2 lg:grid-cols-1">
            <?php
            $categories = [];
            foreach ($posts as $post) {
                $categoryName = (string) ($post['category'] ?? 'General');
                $categorySlug = (string) ($post['category_slug'] ?? blogger_normalize_category_slug($categoryName));
                if (!isset($categories[$categorySlug])) {
                    $categories[$categorySlug] = ['name' => $categoryName, 'count' => 0];
                }
                $categories[$categorySlug]['count']++;
            }
            asort($categories);
            ?>
            <?php foreach ($categories as $slug => $cat): ?>
                <li>
                    <a class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900"
                       href="<?php echo htmlspecialchars($basePath . '/category/' . rawurlencode($slug), ENT_QUOTES, 'UTF-8'); ?>">
                        <span><?php echo htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="rounded-full bg-white border border-slate-200 px-1.5 py-0.5 text-[10px] font-semibold text-slate-500">
                            <?php echo (int) $cat['count']; ?>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <!-- Suggested Reads -->
    <?php if (!empty($sidebarSuggestions)): ?>
    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-500">Suggested Reads</h2>
        <ul class="mt-3 space-y-4 text-sm">
            <?php foreach ($sidebarSuggestions as $post): ?>
                <li class="flex items-start gap-3">
                    <?php if (!empty($post['thumbnail'])): ?>
                        <img class="h-12 w-16 shrink-0 rounded-lg bg-slate-100 object-cover"
                             src="<?php echo htmlspecialchars($post['thumbnail'], ENT_QUOTES, 'UTF-8'); ?>"
                             alt="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?> thumbnail"
                             loading="lazy" width="64" height="48">
                    <?php endif; ?>
                    <div class="min-w-0">
                        <a class="block text-sm font-medium leading-5 text-slate-800 hover:text-brand-600 hover:underline underline-offset-2"
                           href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                        <p class="mt-1 text-xs text-slate-500">
                            <?php echo htmlspecialchars($post['read_time'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>

    <!-- Quick Links -->
    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-500">Quick Links</h2>
        <ul class="mt-3 space-y-2 text-sm text-slate-700">
            <li><a class="flex items-center gap-1.5 hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/about', ENT_QUOTES, 'UTF-8'); ?>"><i class="bi bi-info-circle text-slate-400" aria-hidden="true"></i> About this publication</a></li>
            <li><a class="flex items-center gap-1.5 hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/contact', ENT_QUOTES, 'UTF-8'); ?>"><i class="bi bi-envelope text-slate-400" aria-hidden="true"></i> Editorial contact</a></li>
            <li><a class="flex items-center gap-1.5 hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/privacy-policy', ENT_QUOTES, 'UTF-8'); ?>"><i class="bi bi-shield text-slate-400" aria-hidden="true"></i> Privacy commitment</a></li>
            <li><a class="flex items-center gap-1.5 hover:text-slate-900" href="<?php echo htmlspecialchars($featuredAuthorUrl, ENT_QUOTES, 'UTF-8'); ?>"><i class="bi bi-person text-slate-400" aria-hidden="true"></i> Meet the author</a></li>
            <li><a class="flex items-center gap-1.5 hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/sitemap', ENT_QUOTES, 'UTF-8'); ?>"><i class="bi bi-map text-slate-400" aria-hidden="true"></i> Sitemap</a></li>
        </ul>
    </section>

    <!-- Disclaimer note -->
    <section class="rounded-xl border border-amber-100 bg-amber-50 p-4 text-xs text-amber-800 shadow-sm">
        <p><strong>Not legal advice.</strong> Content on this site is educational. Consult a qualified professional for jurisdiction-specific legal decisions.</p>
    </section>

</aside>
