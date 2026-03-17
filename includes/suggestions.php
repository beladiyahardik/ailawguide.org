<?php
require_once __DIR__ . '/blogger.php';
if (!isset($posts) || !is_array($posts)) {
    $posts = blogger_fetch_posts($site, 18);
}
$currentPostId = '';
$currentCategorySlug = '';
$currentCategoryName = '';
if (isset($selectedPost) && is_array($selectedPost)) {
    $currentPostId = (string) ($selectedPost['id'] ?? '');
    $currentCategorySlug = (string) ($selectedPost['category_slug'] ?? '');
    $currentCategoryName = (string) ($selectedPost['category'] ?? '');
}
$suggestedPosts = blogger_select_related_posts($posts, $currentPostId, $currentCategorySlug, 3);
$sectionTitle = $currentCategoryName !== '' ? ('More in ' . $currentCategoryName) : 'You may also like';
$sectionSubtitle = $currentCategoryName !== ''
    ? 'Stay in the same lane with handpicked reads from this category.'
    : 'Fresh reads we think you will want to explore next.';
?>
<?php if (!empty($suggestedPosts)): ?>
    <section class="suggestions-panel mt-8 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:mt-10 sm:p-6">
        <div class="suggestions-head">
            <div>
                <p class="suggestions-kicker">Keep reading</p>
                <h2 class="suggestions-title"><?php echo htmlspecialchars($sectionTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
                <p class="suggestions-subtitle"><?php echo htmlspecialchars($sectionSubtitle, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>
        <div class="suggestions-grid mt-4">
            <?php foreach ($suggestedPosts as $post): ?>
                <article>
                    <a class="suggestion-card" href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php if (!empty($post['thumbnail'])): ?>
                            <div class="suggestion-media">
                                <img src="<?php echo htmlspecialchars($post['thumbnail'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?> thumbnail" loading="lazy">
                            </div>
                        <?php endif; ?>
                        <div class="suggestion-body">
                            <?php if (!empty($post['category'])): ?>
                                <span class="suggestion-category"><?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php endif; ?>
                            <h3 class="suggestion-title"><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p class="suggestion-excerpt"><?php echo htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <div class="suggestion-meta">
                                <span><?php echo htmlspecialchars($post['read_time'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="suggestion-cta">Read now</span>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
