</main>
<?php $basePath = rtrim((string) ($site['base_path'] ?? '/'), '/'); ?>
<footer class="border-t border-slate-200 bg-white">
    <div class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <h2 class="text-sm font-semibold uppercase tracking-widest text-slate-700">AI Law Guide</h2>
                <p class="mt-3 text-sm leading-7 text-slate-600"><?php echo htmlspecialchars($site['tagline'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p class="mt-3 text-sm leading-7 text-slate-600">Independent analysis of AI regulation, model risk, and compliance operations for product teams.</p>
            </div>
            <div>
                <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-700">Navigate</h2>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>">Home</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/about', ENT_QUOTES, 'UTF-8'); ?>">About</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/contact', ENT_QUOTES, 'UTF-8'); ?>">Contact</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/privacy-policy', ENT_QUOTES, 'UTF-8'); ?>">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-700">Legal</h2>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/cookie-policy', ENT_QUOTES, 'UTF-8'); ?>">Cookie Policy</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/terms', ENT_QUOTES, 'UTF-8'); ?>">Terms of Use</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/disclaimer', ENT_QUOTES, 'UTF-8'); ?>">Disclaimer</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/gdpr', ENT_QUOTES, 'UTF-8'); ?>">EU Privacy (GDPR)</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/us-privacy-rights', ENT_QUOTES, 'UTF-8'); ?>">US Privacy Rights</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/sitemap', ENT_QUOTES, 'UTF-8'); ?>">Sitemap</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-8 flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 pt-4 text-xs text-slate-500">
            <p>&copy; <?php echo date('Y'); ?> AI Law Guide. All rights reserved.</p>
            <p>Last updated: <?php echo htmlspecialchars($site['updated_at'], ENT_QUOTES, 'UTF-8'); ?>.</p>
        </div>
    </div>
</footer>
<div id="image-lightbox" class="image-lightbox" aria-hidden="true">
    <div class="image-lightbox__backdrop" data-lightbox-close></div>
    <div class="image-lightbox__dialog" role="dialog" aria-modal="true" aria-label="Image preview">
        <button class="image-lightbox__close" type="button">Close</button>
        <img class="image-lightbox__img" alt="">
    </div>
</div>
<script>
  (function() {
    const lightbox = document.getElementById('image-lightbox');
    if (!lightbox) return;
    const imgEl = lightbox.querySelector('.image-lightbox__img');
    const closeBtn = lightbox.querySelector('.image-lightbox__close');
    const backdrop = lightbox.querySelector('[data-lightbox-close]');
    const pageImages = document.querySelectorAll('.article-content img');
    if (!imgEl || !closeBtn || !backdrop || pageImages.length === 0) return;

    const openLightbox = (img) => {
      const src = img.currentSrc || img.src;
      if (!src) return;
      imgEl.src = src;
      imgEl.alt = img.alt || 'Expanded image';
      lightbox.classList.add('is-open');
      lightbox.setAttribute('aria-hidden', 'false');
      document.body.classList.add('lightbox-open');
    };

    const closeLightbox = () => {
      lightbox.classList.remove('is-open');
      lightbox.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('lightbox-open');
    };

    pageImages.forEach((img) => {
      const parentLink = img.closest('a');
      if (parentLink) {
        parentLink.removeAttribute('href');
        parentLink.removeAttribute('target');
        parentLink.removeAttribute('rel');
        parentLink.addEventListener('click', function(event) {
          event.preventDefault();
        });
      }
      img.addEventListener('click', function(event) {
        event.preventDefault();
        openLightbox(img);
      });
    });

    closeBtn.addEventListener('click', closeLightbox);
    backdrop.addEventListener('click', closeLightbox);
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape' && lightbox.classList.contains('is-open')) {
        closeLightbox();
      }
    });
  })();
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YSM0PHETRT"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YSM0PHETRT');
</script>
</body>
</html>
<?php
if (!empty($cacheBuffering)) {
    $cachedHtml = ob_get_clean();
    if ($cachedHtml !== false) {
        @file_put_contents($cacheFile, $cachedHtml, LOCK_EX);
        echo $cachedHtml;
    }
}
?>
