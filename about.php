<?php
require __DIR__ . '/includes/page-cache.php';
$site = require __DIR__ . '/includes/site.php';
$pageTitle       = 'About AI Law Guide | Who We Are & How We Research';
$metaDescription = 'AI Law Guide is an independent publication led by Rahul Beladiya, a legal tech strategist and writer covering AI, legal technology, and digital transformation.';
$basePath = rtrim((string) ($site['base_path'] ?? '/'), '/');
$authorProfilePath = (string) ($site['author_profile_path'] ?? ($basePath . '/author/rahul-beladiya'));
$origin = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? '');
$metaUrl = $origin . ($basePath === '' ? '' : $basePath) . '/about';

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
      "jobTitle": "<?php echo htmlspecialchars($site['author_title'] ?? 'Provides guidance on AI adoption within legal frameworks.', ENT_QUOTES, 'UTF-8'); ?>",
      "description": "<?php echo htmlspecialchars($site['author_bio'] ?? '', ENT_QUOTES, 'UTF-8'); ?>",
      "url": "<?php echo htmlspecialchars($origin . $authorProfilePath, ENT_QUOTES, 'UTF-8'); ?>",
      "sameAs": [
        "https://github.com/rcbeladiya"
      ],
      "worksFor": {
        "@type": "Organization",
        "name": "AI Law Guide",
        "url": "<?php echo htmlspecialchars($origin . ($basePath === '' ? '' : $basePath), ENT_QUOTES, 'UTF-8'); ?>"
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
                <p class="mt-0.5 text-sm font-medium text-slate-600" itemprop="jobTitle"><?php echo htmlspecialchars($site['author_title'] ?? 'Provides guidance on AI adoption within legal frameworks.', ENT_QUOTES, 'UTF-8'); ?></p>
                <p class="mt-3 text-sm leading-7 text-slate-700" itemprop="description">
                    I’m a Legal Tech strategist and writer who focuses on the blend of law, AI, and digital change. Through my writing on the Legal Tech Ecosystem, I help in-house legal teams, law firms, and tech companies navigate the fast-changing world of artificial intelligence, legal tech tools, and digital support. Whether it’s setting up AI-powered contract lifecycle management, creating future-ready legal operations, or choosing the right technology for compliance and efficiency, I break down complex innovations into practical, actionable strategies.
                </p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="rounded-full bg-white border border-brand-200 px-3 py-1 text-xs font-medium text-brand-700">Legal Technology</span>
                    <span class="rounded-full bg-white border border-brand-200 px-3 py-1 text-xs font-medium text-brand-700">AI in Legal Workflows</span>
                    <span class="rounded-full bg-white border border-brand-200 px-3 py-1 text-xs font-medium text-brand-700">Contract Lifecycle Management</span>
                    <span class="rounded-full bg-white border border-brand-200 px-3 py-1 text-xs font-medium text-brand-700">Legal Operations</span>
                    <span class="rounded-full bg-white border border-brand-200 px-3 py-1 text-xs font-medium text-brand-700">Digital Transformation</span>
                </div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <?php if (!empty($site['author_github'])): ?>
                        <a href="<?php echo htmlspecialchars($site['author_github'], ENT_QUOTES, 'UTF-8'); ?>" rel="noopener noreferrer" target="_blank"
                           class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition">
                            <i class="bi bi-github" aria-hidden="true"></i> GitHub
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo htmlspecialchars($authorProfilePath, ENT_QUOTES, 'UTF-8'); ?>"
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
            <strong>Not legal advice.</strong> Everything published here is educational and informational. For legal advice or decisions with real legal or financial consequences, consult a qualified professional in your jurisdiction.
        </p>
    </div>

    <!-- Main content -->
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 space-y-6">

        <div>
            <h2 class="text-xl font-bold text-slate-900">Why I Built This</h2>
            <p class="mt-3 text-slate-700 leading-7">AI, legal technology, and digital transformation are reshaping how legal work gets done. Yet many legal teams and technology companies still face the same challenge: there is no shortage of tools, trends, or vendor promises, but there is often very little clear guidance on what actually matters, what is practical to implement, and how to align technology choices with legal and operational goals.</p>
            <p class="mt-3 text-slate-700 leading-7">I built AI Law Guide to close that gap. My aim is to translate complex innovation into practical strategies that legal professionals and tech leaders can use with confidence, whether they are evaluating legal tech platforms, modernizing legal operations, or exploring responsible uses of AI inside legal workflows.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">What We Cover</h2>
            <p class="mt-3 text-slate-700 leading-7">AI Law Guide focuses on the intersection of AI, legal technology, and practical digital change. That means:</p>
            <ul class="mt-3 space-y-2 text-slate-700 list-disc pl-5 leading-7">
                <li><strong>AI-powered contract lifecycle management:</strong> how legal teams can evaluate and implement smarter workflows for drafting, review, approval, and ongoing contract management.</li>
                <li><strong>Future-ready legal operations:</strong> building legal functions that are more efficient, scalable, and better aligned with business needs.</li>
                <li><strong>Legal tech ecosystem analysis:</strong> understanding categories, platforms, and vendors across the legal technology landscape.</li>
                <li><strong>Compliance and efficiency strategy:</strong> choosing tools and processes that support both operational performance and legal responsibilities.</li>
                <li><strong>Digital transformation for legal teams:</strong> modernizing legal work through automation, workflow design, and stronger digital support.</li>
                <li><strong>Practical AI adoption:</strong> using AI in legal environments in ways that are clear, useful, and grounded in real organizational needs.</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">How I Research</h2>
            <p class="mt-3 text-slate-700 leading-7">My work starts with understanding the real problem legal teams or technology firms are trying to solve. From there, I look at legal requirements, operational demands, available tools, and implementation trade-offs together rather than in isolation. That helps keep the guidance practical instead of purely theoretical.</p>
            <p class="mt-3 text-slate-700 leading-7">I focus on clarity, applicability, and decision-making value. Instead of repeating product language or abstract trends, I aim to explain what a technology shift means in practice, where it can create value, where it can introduce risk, and how teams can move forward with better judgment.</p>
            <p class="mt-3 text-slate-700 leading-7">Where nuance matters, I keep it visible. Where a recommendation depends on organizational context, I say so. If you spot an error or want to suggest an update, <a class="underline hover:text-brand-600" href="<?php echo htmlspecialchars($basePath . '/contact', ENT_QUOTES, 'UTF-8'); ?>">contact me</a> and I will review it promptly.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Editorial Standards</h2>
            <ul class="mt-3 space-y-2.5 text-slate-700 pl-0 list-none">
                <?php
                $standards = [
                    ['bi-check-circle-fill text-brand-600', 'Practical before performative. Content should help readers make better technology and operational decisions.'],
                    ['bi-check-circle-fill text-brand-600', 'No fabricated citations, no fake statistics, and no inflated claims.'],
                    ['bi-check-circle-fill text-brand-600', 'Clear, plain-language explanations of complex legal tech and AI topics.'],
                    ['bi-check-circle-fill text-brand-600', 'Visible updates and prompt corrections when material issues are identified.'],
                    ['bi-check-circle-fill text-brand-600', 'Transparent about monetization. Advertising does not influence factual claims or recommendations.'],
                    ['bi-check-circle-fill text-brand-600', 'Written for human readers who need clarity, not for search engines at the expense of usefulness.'],
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
            <p class="mt-3 text-slate-700 leading-7">The core readership includes in-house legal teams, law firms, legal operations professionals, and technology companies that need clearer ways to think about AI, legal technology, and digital change. The site is designed to help both legal and business stakeholders move from uncertainty to informed action.</p>
            <div class="mt-4 grid gap-3 sm:grid-cols-3">
                <?php
                $audiences = [
                    ['bi-building', 'In-House Legal Teams', 'Who want practical guidance on legal tech adoption, workflows, and operational improvement.'],
                    ['bi-briefcase', 'Law Firms', 'Who are exploring AI, legal technology, and service delivery models in a changing market.'],
                    ['bi-cpu', 'Technology Companies', 'Who need clearer ways to evaluate legal tech, compliance workflows, and digital support for legal functions.'],
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
            <p class="mt-3 text-slate-700 leading-7">AI Law Guide displays contextual advertising through Google AdSense and may include clearly disclosed affiliate links where relevant. Revenue supports site maintenance, hosting, and the time spent researching and writing. It does not determine what gets covered or how it is analyzed. I do not sell coverage, accept undisclosed sponsored content, or allow advertiser relationships to shape editorial judgment.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Update &amp; Correction Process</h2>
            <p class="mt-3 text-slate-700 leading-7">AI, legal technology, and digital workflows evolve quickly. When something materially changes, whether in tools, market direction, or the practical implications for legal teams, I update the relevant pages and revise the page-level date. If you believe something is factually incorrect, contact me with the page URL, the specific claim, and a supporting source. I review credible correction requests and respond with an update or clarifying note where needed.</p>
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
