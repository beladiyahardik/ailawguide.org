<?php
require_once __DIR__ . '/blogger.php';
if (!isset($posts) || !is_array($posts)) {
    $posts = blogger_fetch_posts($site, 9);
}
?>
<section class="mt-8 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:mt-10 sm:p-6">
    <h2 class="text-lg font-semibold">You may also like</h2>
    <div class="mt-4 space-y-3">
        <?php foreach (array_slice($posts, 0, 3) as $post): ?>
            <a class="flex overflow-hidden rounded-lg border border-slate-200 hover:border-slate-300 hover:bg-slate-50" href="<?php echo htmlspecialchars($post['url'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php if (!empty($post['thumbnail'])): ?>
                    <img class="h-28 w-32 flex-shrink-0 bg-slate-100 object-contain sm:h-32 sm:w-40" src="<?php echo htmlspecialchars($post['thumbnail'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?> thumbnail" loading="lazy">
                <?php endif; ?>
                <div class="p-4 text-left">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500"><?php echo htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <h3 class="mt-2 text-sm font-semibold leading-6 text-slate-900"><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="mt-2 text-xs text-slate-500"><?php echo htmlspecialchars($post['read_time'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
