<?php
require __DIR__ . '/includes/page-cache.php';
$site = require __DIR__ . '/includes/site.php';
require __DIR__ . '/includes/blogger.php';
$blogDescription = blogger_blog_description($site);

$categorySlug = (string) ($_GET['category'] ?? '');
if ($categorySlug === '') {
    $uriPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    if (is_string($uriPath) && preg_match('#/category/([^/]+)/?$#', $uriPath, $matches)) {
        $categorySlug = (string) $matches[1];
    }
}

$categorySlug = blogger_normalize_category_slug($categorySlug);
$posts = blogger_fetch_posts($site, 100);
$categoryPosts = blogger_filter_posts_by_category($posts, $categorySlug);
$categoryName = blogger_resolve_category_name($posts, $categorySlug);
$apiError = blogger_last_error();
$basePath = rtrim((string) ($site['base_path'] ?? '/'), '/');

$pageTitle = 'Category: ' . $categoryName . ' | AI Law Guide';
$metaDescription = 'Browse blog posts in category: ' . $categoryName . '.';
if ($blogDescription !== '') {
    $metaDescription = $metaDescription . ' ' . $blogDescription;
}
require __DIR__ . '/includes/header.php';
?>
<section class="grid gap-6 lg:grid-cols-3 lg:gap-8 xl:gap-10">
    <div class="min-w-0 space-y-6 lg:col-span-2">
        <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-xs text-slate-500">
            <a href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>" class="hover:text-slate-800 hover:underline">Home</a>
            <span aria-hidden="true">/</span>
            <span class="font-medium text-slate-700" aria-current="page"><?php echo htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8'); ?></span>
        </nav>

        <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Category</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight sm:text-3xl"><?php echo htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="mt-2 text-sm text-slate-600">Total posts: <?php echo (int) count($categoryPosts); ?></p>
        </section>

        <?php if (!empty($categoryPosts)): ?>
            <?php foreach ($categoryPosts as $post): ?>
                <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="blog-list-card">
                        <?php if (!empty($post['thumbnail'])): ?>
                            <a class="blog-list-thumb block" href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>">
                                <img class="blog-list-img" src="<?php echo htmlspecialchars($post['thumbnail'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?> thumbnail" loading="lazy">
                            </a>
                        <?php endif; ?>
                        <div class="blog-list-body p-4 sm:p-5">
                            <h2 class="text-lg font-semibold sm:text-xl">
                                <a class="hover:underline" href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></a>
                            </h2>
                            <p class="mt-2 text-sm leading-7 text-slate-600 sm:text-base"><?php echo htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="mt-3 text-xs text-slate-500 sm:text-sm"><?php echo htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?> &bull; <?php echo htmlspecialchars($post['read_time'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <section class="rounded-xl border border-amber-300 bg-amber-50 p-5 sm:p-6">
                <h2 class="text-lg font-semibold sm:text-xl">No posts found in this category</h2>
                <p class="mt-2 text-sm text-amber-900">Reason: <?php echo htmlspecialchars($apiError !== '' ? $apiError : 'No matching posts were returned.', ENT_QUOTES, 'UTF-8'); ?></p>
            </section>
        <?php endif; ?>
    </div>

    <aside class="space-y-6 lg:col-span-1">
        <?php require __DIR__ . '/includes/sidebar.php'; ?>
    </aside>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>





