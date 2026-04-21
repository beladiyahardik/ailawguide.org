<?php
$site = require __DIR__ . '/includes/site.php';

$pageTitle       = 'Contact | AI Law Guide';
$metaDescription = 'Contact AI Law Guide for editorial corrections, partnership inquiries, or privacy requests. We typically respond within 48 hours.';
$metaUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? '') . '/contact';

/* ── Form handling ─────────────────────────────────────── */
$formStatus  = '';
$formSuccess = false;
$formErrors  = [];
$formValues  = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formValues['name']    = trim((string) ($_POST['name']    ?? ''));
    $formValues['email']   = trim((string) ($_POST['email']   ?? ''));
    $formValues['subject'] = trim((string) ($_POST['subject'] ?? ''));
    $formValues['message'] = trim((string) ($_POST['message'] ?? ''));

    if ($formValues['name'] === '') {
        $formErrors[] = 'Name is required.';
    }
    if ($formValues['email'] === '' || !filter_var($formValues['email'], FILTER_VALIDATE_EMAIL)) {
        $formErrors[] = 'A valid email address is required.';
    }
    if ($formValues['message'] === '' || strlen($formValues['message']) < 10) {
        $formErrors[] = 'Please include a message of at least 10 characters.';
    }

    if (empty($formErrors)) {
        $to      = $site['contact_email'];
        $subject = '[AI Law Guide Contact] ' . ($formValues['subject'] !== '' ? $formValues['subject'] : 'Message from ' . $formValues['name']);
        $body    = "Name: {$formValues['name']}\nEmail: {$formValues['email']}\n\nMessage:\n{$formValues['message']}";
        $headers = "From: noreply@ailawguide.org\r\nReply-To: {$formValues['email']}\r\nContent-Type: text/plain; charset=UTF-8";
        $sent    = @mail($to, $subject, $body, $headers);
        if ($sent) {
            $formSuccess = true;
            $formValues  = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];
        } else {
            $formErrors[] = 'Message could not be sent right now. Please email us directly.';
        }
    }
}

ob_start();
?>
<link rel="canonical" href="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($metaUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:site_name" content="AI Law Guide">
<meta name="robots" content="index, follow">
<meta name="author" content="Rahul Beladiya">
<?php
$extraHeadTags = ob_get_clean();
require __DIR__ . '/includes/header.php';
$basePath = rtrim((string) ($site['base_path'] ?? '/'), '/');
?>

<!-- Breadcrumb -->
<nav class="mb-5 flex items-center gap-2 text-sm text-slate-500" aria-label="Breadcrumb">
    <a href="<?php echo htmlspecialchars($basePath . '/', ENT_QUOTES, 'UTF-8'); ?>" class="hover:text-slate-900">Home</a>
    <span aria-hidden="true" class="text-slate-300">/</span>
    <span class="font-medium text-slate-700" aria-current="page">Contact</span>
</nav>

<div class="grid gap-6 md:grid-cols-2">

    <!-- Contact info -->
    <div class="space-y-5">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900">Get in Touch</h1>
            <p class="mt-3 text-sm leading-7 text-slate-700">Have a correction, question, partnership inquiry, or feedback about a specific article? Use the form or email directly.</p>

            <ul class="mt-5 space-y-4">
                <li class="flex items-start gap-3">
                    <i class="bi bi-envelope mt-0.5 shrink-0 text-lg text-brand-600" aria-hidden="true"></i>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Email</p>
                        <a class="text-sm font-medium text-slate-800 underline underline-offset-2 hover:text-brand-600"
                           href="mailto:<?php echo htmlspecialchars($site['contact_email'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($site['contact_email'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <i class="bi bi-clock mt-0.5 shrink-0 text-lg text-brand-600" aria-hidden="true"></i>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Response time</p>
                        <p class="text-sm text-slate-700">We aim to reply within 48 hours on business days. Correction requests with a source reference are prioritised.</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <i class="bi bi-patch-check mt-0.5 shrink-0 text-lg text-brand-600" aria-hidden="true"></i>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Corrections & Feedback</p>
                        <p class="text-sm text-slate-700">If you spot a factual issue, include the page URL, the specific claim, and your source. We review every credible correction request.</p>
                    </div>
                </li>
            </ul>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-900">What We Can Help With</h2>
            <ul class="mt-3 space-y-2 text-sm text-slate-700">
                <li class="flex items-center gap-2"><i class="bi bi-check text-brand-600" aria-hidden="true"></i> Editorial corrections or updates</li>
                <li class="flex items-center gap-2"><i class="bi bi-check text-brand-600" aria-hidden="true"></i> Partnership or collaboration requests</li>
                <li class="flex items-center gap-2"><i class="bi bi-check text-brand-600" aria-hidden="true"></i> Privacy or data rights inquiries</li>
                <li class="flex items-center gap-2"><i class="bi bi-check text-brand-600" aria-hidden="true"></i> Article suggestions or topic requests</li>
                <li class="flex items-center gap-2"><i class="bi bi-check text-brand-600" aria-hidden="true"></i> Copyright or content concerns</li>
            </ul>
            <p class="mt-3 text-xs text-slate-500">We do not provide individual legal advice through this contact form. For legal questions specific to your situation, please consult a qualified professional.</p>
        </section>
    </div>

    <!-- Contact form -->
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-slate-900">Send a Message</h2>

        <?php if ($formSuccess): ?>
            <div class="mt-4 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4">
                <i class="bi bi-check-circle-fill mt-0.5 shrink-0 text-green-600" aria-hidden="true"></i>
                <div>
                    <p class="text-sm font-semibold text-green-800">Message sent successfully.</p>
                    <p class="mt-1 text-sm text-green-700">Thank you for reaching out. We will review your message and reply within 48 hours.</p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($formErrors)): ?>
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4">
                <p class="text-sm font-semibold text-red-800">Please fix the following:</p>
                <ul class="mt-1.5 list-disc pl-4 text-sm text-red-700 space-y-1">
                    <?php foreach ($formErrors as $err): ?>
                        <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="mt-5 space-y-4" method="post" action="<?php echo htmlspecialchars($basePath . '/contact', ENT_QUOTES, 'UTF-8'); ?>" novalidate>
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Your Name <span class="text-red-500" aria-hidden="true">*</span></span>
                    <input class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500"
                           type="text" name="name" required autocomplete="name"
                           value="<?php echo htmlspecialchars($formValues['name'], ENT_QUOTES, 'UTF-8'); ?>">
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Email Address <span class="text-red-500" aria-hidden="true">*</span></span>
                    <input class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500"
                           type="email" name="email" required autocomplete="email"
                           value="<?php echo htmlspecialchars($formValues['email'], ENT_QUOTES, 'UTF-8'); ?>">
                </label>
            </div>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Subject</span>
                <input class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500"
                       type="text" name="subject"
                       value="<?php echo htmlspecialchars($formValues['subject'], ENT_QUOTES, 'UTF-8'); ?>"
                       placeholder="e.g. Correction for EU AI Act article">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Message <span class="text-red-500" aria-hidden="true">*</span></span>
                <textarea class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500"
                          name="message" rows="6" required
                          placeholder="Describe your question, correction request, or inquiry..."><?php echo htmlspecialchars($formValues['message'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </label>
            <p class="text-xs text-slate-500">By submitting this form you agree to our <a class="underline" href="<?php echo htmlspecialchars($basePath . '/privacy-policy', ENT_QUOTES, 'UTF-8'); ?>">Privacy Policy</a>.</p>
            <button class="w-full rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 sm:w-auto"
                    type="submit">Send Message</button>
        </form>
    </section>

</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
