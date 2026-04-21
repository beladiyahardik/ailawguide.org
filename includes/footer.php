</main>
<?php
$basePath  = rtrim((string) ($site['base_path'] ?? '/'), '/');
$siteUrl   = rtrim((string) ($site['site_url'] ?? ''), '/');
$scheme    = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host      = (string) ($_SERVER['HTTP_HOST'] ?? '');
$canonicalBase = $host !== '' ? ($scheme . '://' . $host) : $siteUrl;
?>

<!-- Organization JSON-LD (global, every page) -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "AI Law Guide",
  "url": "<?php echo htmlspecialchars($canonicalBase . ($basePath === '/' ? '' : $basePath) . '/', ENT_QUOTES, 'UTF-8'); ?>",
  "description": "<?php echo htmlspecialchars($site['tagline'] ?? '', ENT_QUOTES, 'UTF-8'); ?>",
  "contactPoint": {
    "@type": "ContactPoint",
    "email": "<?php echo htmlspecialchars($site['contact_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>",
    "contactType": "editorial"
  },
  "sameAs": [
    "https://github.com/rcbeladiya"
  ]
}
</script>

<footer class="border-t border-slate-200 bg-white">
    <div class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">

            <!-- Brand + mission -->
            <div class="sm:col-span-2 lg:col-span-2">
                <a class="text-sm font-bold uppercase tracking-widest text-slate-800 hover:text-slate-600"
                   href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>">
                    AI Law Guide
                </a>
                <p class="mt-3 max-w-sm text-sm leading-7 text-slate-600">
                    <?php echo htmlspecialchars($site['tagline'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                </p>
                <p class="mt-2 max-w-sm text-sm leading-7 text-slate-500">
                    Independent, practitioner-focused analysis of AI regulation, model risk, and compliance operations. Written by an AI developer, not a law firm.
                </p>
                <!-- Social / contact links -->
                <div class="mt-4 flex items-center gap-3">
                    <?php if (!empty($site['author_github'])): ?>
                        <a href="<?php echo htmlspecialchars($site['author_github'], ENT_QUOTES, 'UTF-8'); ?>"
                           rel="noopener noreferrer" target="_blank"
                           aria-label="GitHub"
                           class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-slate-300 hover:text-slate-800">
                            <i class="bi bi-github text-base" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                    <a href="mailto:<?php echo htmlspecialchars($site['contact_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                       aria-label="Email"
                       class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-slate-300 hover:text-slate-800">
                        <i class="bi bi-envelope text-base" aria-hidden="true"></i>
                    </a>
                </div>
                <!-- Trust badge -->
                <div class="mt-4 inline-flex items-center gap-2 rounded-lg border border-slate-100 bg-slate-50 px-3 py-2 text-xs text-slate-500">
                    <i class="bi bi-shield-check text-brand-500" aria-hidden="true"></i>
                    Independent publication &bull; No sponsored editorial &bull; Educational content
                </div>
            </div>

            <!-- Navigate -->
            <div>
                <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-700">Navigate</h2>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>">Home</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/about', ENT_QUOTES, 'UTF-8'); ?>">About</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/contact', ENT_QUOTES, 'UTF-8'); ?>">Contact</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/privacy-policy', ENT_QUOTES, 'UTF-8'); ?>">Privacy Policy</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/sitemap', ENT_QUOTES, 'UTF-8'); ?>">Sitemap</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-700">Legal</h2>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/cookie-policy', ENT_QUOTES, 'UTF-8'); ?>">Cookie Policy</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/terms', ENT_QUOTES, 'UTF-8'); ?>">Terms of Use</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/disclaimer', ENT_QUOTES, 'UTF-8'); ?>">Disclaimer</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/gdpr', ENT_QUOTES, 'UTF-8'); ?>">EU Privacy (GDPR)</a></li>
                    <li><a class="hover:text-slate-900" href="<?php echo htmlspecialchars($basePath . '/us-privacy-rights', ENT_QUOTES, 'UTF-8'); ?>">US Privacy Rights</a></li>
                </ul>
            </div>

        </div>

        <!-- Bottom bar -->
        <div class="mt-8 flex flex-col gap-2 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-xs text-slate-500">
                &copy; <?php echo date('Y'); ?> AI Law Guide. All rights reserved.
                Content is educational and not legal advice.
            </p>
            <p class="text-xs text-slate-400">
                Last updated: <?php echo htmlspecialchars($site['updated_at'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
            </p>
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
(function () {
    const lightbox  = document.getElementById('image-lightbox');
    if (!lightbox) return;
    const imgEl     = lightbox.querySelector('.image-lightbox__img');
    const closeBtn  = lightbox.querySelector('.image-lightbox__close');
    const backdrop  = lightbox.querySelector('[data-lightbox-close]');
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
            parentLink.addEventListener('click', (e) => e.preventDefault());
        }
        img.addEventListener('click', (e) => { e.preventDefault(); openLightbox(img); });
    });

    closeBtn.addEventListener('click', closeLightbox);
    backdrop.addEventListener('click', closeLightbox);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox.classList.contains('is-open')) {
            closeLightbox();
        }
    });
})();
</script>

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YSM0PHETRT"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag() { dataLayer.push(arguments); }
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
