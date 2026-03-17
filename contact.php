<?php
$pageTitle = 'Contact | AI Law Guide';
$metaDescription = 'Contact AI Law Guide for editorial or privacy requests.';
require __DIR__ . '/includes/header.php';
?>
<section class="grid gap-6 md:grid-cols-2">
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <h1 class="text-2xl font-bold">Contact</h1>
        <p class="mt-3 text-sm leading-7 text-slate-700 sm:text-base">For editorial inquiries, partnership requests, or corrections:</p>
        <p class="mt-2 text-sm text-slate-700 sm:text-base"><strong>Email:</strong> <a class="underline" href="mailto:<?php echo htmlspecialchars($site['contact_email'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($site['contact_email'], ENT_QUOTES, 'UTF-8'); ?></a></p>
        <p class="mt-2 text-sm text-slate-700 sm:text-base"><strong>Business hours:</strong> Monday to Friday, 9:00 AM to 5:00 PM (US Eastern Time)</p>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <h2 class="text-xl font-semibold">Contact Form</h2>
        <form class="mt-4 space-y-4" method="post" action="#">
            <label class="block text-sm font-medium text-slate-700">Name
                <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-base" type="text" name="name" required>
            </label>
            <label class="block text-sm font-medium text-slate-700">Email
                <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-base" type="email" name="email" required>
            </label>
            <label class="block text-sm font-medium text-slate-700">Message
                <textarea class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-base" name="message" rows="5" required></textarea>
            </label>
            <button class="w-full rounded-lg bg-slate-900 px-4 py-2.5 text-white hover:bg-slate-700 sm:w-auto" type="submit">Send</button>
        </form>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

