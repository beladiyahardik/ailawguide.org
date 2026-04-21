<?php
$site = require __DIR__ . '/includes/site.php';
$pageTitle       = 'About AI Law Guide | Who We Are & How We Research';
$metaDescription = 'AI Law Guide is an independent publication run by Rahul Beladiya, an AI developer tracking global AI regulation to help founders and product teams build compliant systems.';
$metaUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? '') . '/about';

ob_start();
?>
<link rel="canonical" href="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:type" content="profile">
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:site_name" content="AI Law Guide">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="robots" content="index, follow">
<meta name="author" content="Rahul Beladiya">

<!-- JSON-LD: Person + Organization -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Person",
      "@id": "<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>#author",
      "name": "Rahul Beladiya",
      "jobTitle": "AI Developer & Regulatory Researcher",
      "description": "<?php echo htmlspecialchars($site['author_bio'] ?? '', ENT_QUOTES, 'UTF-8'); ?>",
      "url": "<?php echo htmlspecialchars(rtrim($metaUrl, '/about'), ENT_QUOTES, 'UTF-8'); ?>/author/rahul-beladiya",
      "sameAs": [
        "https://github.com/rcbeladiya"
      ],
      "worksFor": {
        "@type": "Organization",
        "name": "AI Law Guide",
        "url": "<?php echo htmlspecialchars(rtrim($metaUrl, '/about'), ENT_QUOTES, 'UTF-8'); ?>"
      }
    },
    {
      "@type": "WebPage",
      "url": "<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>",
      "name": "<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>",
      "description": "<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>",
      "publisher": {
        "@type": "Organization",
        "name": "AI Law Guide"
      }
    }
  ]
}
</script>
<?php
$extraHeadTags = ob_get_clean();

require __DIR__ . '/includes/header.php';
$basePath = rtrim((string) ($site['base_path'] ?? '/'), '/');
?>

<!-- Breadcrumb -->
<nav class="mb-5 flex items-center gap-2 text-sm text-slate-500" aria-label="Breadcrumb">
    <a href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>" class="hover:text-slate-900">Home</a>
    <span aria-hidden="true" class="text-slate-300">/</span>
    <span class="font-medium text-slate-700" aria-current="page">About</span>
</nav>

<div class="space-y-6">

    <!-- Author credential card (E-E-A-T signal) -->
    <section class="rounded-2xl border border-brand-200 bg-brand-50 p-6 shadow-sm sm:p-7" itemscope itemtype="https://schema.org/Person">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-brand-600 text-2xl font-bold text-white shadow">
                R
            </div>
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">Written &amp; maintained by</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900" itemprop="name">Rahul Beladiya</h1>
                <p class="mt-0.5 text-sm font-medium text-slate-600" itemprop="jobTitle">AI Developer &amp; Regulatory Researcher</p>
                <p class="mt-3 text-sm leading-7 text-slate-700" itemprop="description">
                    I build AI systems for a living and I track global AI regulation as a discipline. I started this site because I kept seeing the same gap: engineers and founders who understood the technology but had no clear path through the compliance requirements. Legal articles were either too abstract to act on, or too shallow to trust. I decided to fix that for myself and publish it publicly so others could benefit.
                </p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="rounded-full bg-white border border-brand-200 px-3 py-1 text-xs font-medium text-brand-700">AI Systems Development</span>
                    <span class="rounded-full bg-white border border-brand-200 px-3 py-1 text-xs font-medium text-brand-700">EU AI Act</span>
                    <span class="rounded-full bg-white border border-brand-200 px-3 py-1 text-xs font-medium text-brand-700">Regulatory Research</span>
                    <span class="rounded-full bg-white border border-brand-200 px-3 py-1 text-xs font-medium text-brand-700">Privacy &amp; Governance</span>
                    <span class="rounded-full bg-white border border-brand-200 px-3 py-1 text-xs font-medium text-brand-700">Model Risk</span>
                </div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <?php if (!empty($site['author_github'])): ?>
                        <a href="<?php echo htmlspecialchars($site['author_github'], ENT_QUOTES, 'UTF-8'); ?>" rel="noopener noreferrer" target="_blank"
                           class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition">
                            <i class="bi bi-github" aria-hidden="true"></i> GitHub
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo htmlspecialchars($basePath . '/author/rahul-beladiya', ENT_QUOTES, 'UTF-8'); ?>"
                       class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        <i class="bi bi-person-circle" aria-hidden="true"></i> Full Author Profile
                    </a>
                    <a href="<?php echo htmlspecialchars($basePath . '/contact', ENT_QUOTES, 'UTF-8'); ?>"
                       class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        <i class="bi bi-envelope" aria-hidden="true"></i> Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Not legal advice callout -->
    <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 px-5 py-4">
        <i class="bi bi-info-circle mt-0.5 shrink-0 text-lg text-amber-600" aria-hidden="true"></i>
        <p class="text-sm leading-6 text-amber-800">
            <strong>Not legal advice.</strong> I am a developer, not a lawyer. Everything published here is educational and informational. For decisions with real legal or financial consequences, consult a qualified professional in your jurisdiction.
        </p>
    </div>

    <!-- Main content -->
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 space-y-6">

        <div>
            <h2 class="text-xl font-bold text-slate-900">Why I Built This</h2>
            <p class="mt-3 text-slate-700 leading-7">In 2023 and 2024, AI regulation went from theoretical to real at a pace most engineering teams were not prepared for. The EU AI Act moved from draft to enacted law. US states started passing their own AI and privacy rules. Frameworks like NIST AI RMF became referenced in procurement requirements. Meanwhile, the resources available to developers were mostly written by lawyers for lawyers: dense, jurisdiction-specific, and almost impossible to turn into tickets.</p>
            <p class="mt-3 text-slate-700 leading-7">I kept bookmarking articles that were either so high-level they said nothing, or so deep in legal language they were useless without a JD. So I started writing the guides I actually wanted to read: plain language, grounded in primary sources, with concrete next steps. I published them here. That is still what this site is.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">What We Cover</h2>
            <p class="mt-3 text-slate-700 leading-7">AI Law Guide focuses on the intersection of AI engineering and global regulation. That means:</p>
            <ul class="mt-3 space-y-2 text-slate-700 list-disc pl-5 leading-7">
                <li><strong>EU AI Act implementation:</strong> risk classification, documentation requirements, conformity assessment, and timeline checkpoints for product teams.</li>
                <li><strong>US state AI and privacy laws:</strong> including California, Colorado, Texas, and emerging state-level AI governance bills.</li>
                <li><strong>Model risk management:</strong> how to document model development, define release criteria, and maintain audit trails that regulators and customers can verify.</li>
                <li><strong>Vendor and third-party AI governance:</strong> obligations when you use foundation models or external AI services as part of your product stack.</li>
                <li><strong>Privacy and data rights:</strong> GDPR, CCPA, and sector-specific rules that intersect with how AI systems handle personal data.</li>
                <li><strong>Internal policy design:</strong> how to structure acceptable use policies, human oversight checkpoints, and incident response plans for AI features.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">How I Research</h2>
            <p class="mt-3 text-slate-700 leading-7">Every guide starts from primary sources: official legal texts, regulator statements, standards documents (ISO, NIST, IEEE), and binding institutional guidance. I treat secondary commentary as context, not authority. Before publishing, I compare obligations across jurisdictions and distinguish between what is binding, what is likely, and what is still unsettled.</p>
            <p class="mt-3 text-slate-700 leading-7">I also research implementation realities. Laws describe outcomes, not technical steps. What does "meaningful human oversight" look like in a production deployment pipeline? How do you instrument logs to satisfy an audit trail requirement? Those are the questions I try to answer with specificity, not generalities.</p>
            <p class="mt-3 text-slate-700 leading-7">Where I am uncertain, I say so. Where a recommendation depends on jurisdiction or business model, I say so. If you spot an error or find that a regulation has been updated since publication, <a class="underline hover:text-brand-600" href="<?php echo htmlspecialchars($basePath . '/contact', ENT_QUOTES, 'UTF-8'); ?>">contact me</a> with a source reference and I will review it promptly.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Editorial Standards</h2>
            <ul class="mt-3 space-y-2.5 text-slate-700 pl-0 list-none">
                <?php
                $standards = [
                    ['bi-check-circle-fill text-brand-600', 'Primary sources first. Official texts and regulator statements before secondary commentary.'],
                    ['bi-check-circle-fill text-brand-600', 'No fabricated citations, no fake statistics, no invented quotes.'],
                    ['bi-check-circle-fill text-brand-600', 'Clear distinction between binding law, likely requirements, and emerging guidance.'],
                    ['bi-check-circle-fill text-brand-600', 'Visible update dates; material errors corrected and noted promptly.'],
                    ['bi-check-circle-fill text-brand-600', 'Transparent about monetization. Advertising does not influence factual claims.'],
                    ['bi-check-circle-fill text-brand-600', 'Written for human readers, not optimized for search engines at the cost of accuracy.'],
                ];
                foreach ($standards as [$icon, $text]):
                ?>
                <li class="flex items-start gap-2.5">
                    <i class="bi <?php echo $icon; ?> mt-0.5 shrink-0" aria-hidden="true"></i>
                    <span class="text-sm leading-6"><?php echo $text; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Who Reads This</h2>
            <p class="mt-3 text-slate-700 leading-7">The core readership is technical and product-facing: AI engineers, ML engineers, product managers, and startup founders who need to understand compliance requirements without wading through full legal texts. I also see a growing audience of compliance and legal professionals who use the guides as communication bridges to their engineering teams.</p>
            <div class="mt-4 grid gap-3 sm:grid-cols-3">
                <?php
                $audiences = [
                    ['bi-laptop', 'Developers & Engineers', 'Who need to know what "compliant" means at the implementation level.'],
                    ['bi-briefcase', 'Founders & PMs', 'Who are shaping product requirements and need to understand launch obligations.'],
                    ['bi-shield-check', 'Compliance & Legal', 'Who need clear bridges between legal text and engineering decisions.'],
                ];
                foreach ($audiences as [$icon, $title, $desc]):
                ?>
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <i class="bi <?php echo $icon; ?> text-xl text-brand-600" aria-hidden="true"></i>
                    <p class="mt-2 text-sm font-semibold text-slate-900"><?php echo $title; ?></p>
                    <p class="mt-1 text-xs leading-5 text-slate-600"><?php echo $desc; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Monetization &amp; Independence</h2>
            <p class="mt-3 text-slate-700 leading-7">AI Law Guide displays contextual advertising through Google AdSense and may include clearly disclosed affiliate links where relevant. Revenue supports site maintenance, hosting, and the time spent researching and writing. It does not change what I write or which tools I recommend. I do not sell coverage, accept undisclosed sponsored content, or let advertiser relationships influence factual analysis.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Update &amp; Correction Process</h2>
            <p class="mt-3 text-slate-700 leading-7">Regulation moves fast. When something material changes, whether a law is enacted, a regulator publishes new guidance, or a standard is revised, I update the relevant pages and revise the page-level date. If you believe something is factually incorrect, contact me with the page URL, the specific claim, and a source. I review every correction request and respond to credible ones with a content update or a clarifying note.</p>
        </div>

    </section>

    <!-- Policy pages reference -->
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
        <h2 class="text-base font-semibold text-slate-900">Site Governance Documents</h2>
        <p class="mt-2 text-sm text-slate-600">For a full picture of how this site operates, review the following:</p>
        <ul class="mt-3 grid gap-2 sm:grid-cols-2 text-sm">
            <?php
            $policyLinks = [
                ['privacy-policy', 'Privacy Policy', 'How data is collected and handled'],
                ['cookie-policy', 'Cookie Policy', 'Cookie categories and controls'],
                ['terms', 'Terms of Use', 'Acceptable use and content rights'],
                ['disclaimer', 'Disclaimer', 'Scope and limits of educational content'],
                ['gdpr', 'EU Privacy (GDPR)', 'Rights for European readers'],
                ['us-privacy-rights', 'US Privacy Rights', 'Rights for US state residents'],
            ];
            foreach ($policyLinks as [$slug, $label, $desc]):
            ?>
            <li>
                <a class="flex items-start gap-2 rounded-lg border border-slate-100 bg-slate-50 px-3 py-2.5 hover:bg-slate-100 transition"
                   href="<?php echo htmlspecialchars($basePath . '/' . $slug, ENT_QUOTES, 'UTF-8'); ?>">
                    <i class="bi bi-file-text mt-0.5 shrink-0 text-slate-400" aria-hidden="true"></i>
                    <span>
                        <span class="block font-medium text-slate-800"><?php echo $label; ?></span>
                        <span class="text-xs text-slate-500"><?php echo $desc; ?></span>
                    </span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>

</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
