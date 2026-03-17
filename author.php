<?php
$site = require __DIR__ . '/includes/site.php';
require __DIR__ . '/includes/blogger.php';
$blogDescription = blogger_blog_description($site);

$authorKey = (string) ($_GET['author'] ?? '');
if ($authorKey === '') {
    $uriPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    if (is_string($uriPath) && preg_match('#/author/([^/]+)/?$#', $uriPath, $matches)) {
        $authorKey = (string) $matches[1];
    }
}

$authorKey = blogger_normalize_author_key($authorKey);
$posts = blogger_fetch_posts($site, 100);
$author = blogger_find_author($posts, $authorKey);
$authorPosts = blogger_filter_posts_by_author($posts, $authorKey);

$pageTitle = $author ? ($author['name'] . ' | Author | AI Law Guide') : 'Author Profile | AI Law Guide';
$metaDescription = $author
    ? ('Read articles by ' . $author['name'] . ' on AI Law Guide.')
    : ($blogDescription !== '' ? $blogDescription : 'Author profile page.');
require __DIR__ . '/includes/header.php';
?>
<section class="grid gap-6 lg:grid-cols-3 lg:gap-8">
    <div class="space-y-5 sm:space-y-6 lg:col-span-2">
        <?php if ($author): ?>
            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-2">
                    <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($author['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
                    <p class="text-sm text-slate-600">Author profile.</p>
                </div>
                <p class="mt-4 text-sm text-slate-600">Published articles: <?php echo (int) count($authorPosts); ?></p>
            </section>

            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-lg font-semibold sm:text-xl">Articles by <?php echo htmlspecialchars($author['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                <div class="mt-4 space-y-4">
                    <?php foreach ($authorPosts as $post): ?>
                        <article class="rounded-lg border border-slate-200 p-4">
                            <a class="text-base font-semibold hover:underline sm:text-lg" href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></a>
                            <p class="mt-2 text-sm leading-7 text-slate-600"><?php echo htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="mt-2 text-xs text-slate-500"><?php echo htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?> &bull; <?php echo htmlspecialchars($post['read_time'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php else: ?>
            <section class="rounded-xl border border-amber-300 bg-amber-50 p-5 sm:p-6">
                <h1 class="text-lg font-semibold sm:text-xl">Author not found</h1>
                <p class="mt-2 text-sm text-amber-900">No author profile matched this URL.</p>
            </section>
        <?php endif; ?>
    </div>

    <?php require __DIR__ . '/includes/sidebar.php'; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>


