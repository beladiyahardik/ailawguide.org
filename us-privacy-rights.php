<?php
$pageTitle = 'US Privacy Rights | AI Law Guide';
$metaDescription = 'US state privacy rights page covering access, deletion, correction, and opt-out request handling.';
require __DIR__ . '/includes/header.php';
?>
<section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
    <h1 class="text-2xl font-bold">US Privacy Rights</h1>
    <p class="text-sm text-slate-500">Last updated: February 21, 2026</p>
    <p class="text-slate-700">This page describes privacy rights that may apply to residents of certain US states under state privacy laws. Rights and definitions differ by state and are subject to thresholds, exemptions, and implementation rules. We aim to handle requests in good faith and align our process with applicable legal requirements where those laws apply.</p>

    <h2 class="text-xl font-semibold">1. Potential Rights</h2>
    <p class="text-slate-700">Depending on your state, you may have rights such as:</p>
    <ul class="list-disc space-y-1 pl-5 text-slate-700">
        <li>Confirm whether we process personal data about you.</li>
        <li>Access categories or specific pieces of data, where required.</li>
        <li>Request deletion of personal data, subject to legal exceptions.</li>
        <li>Request correction of inaccurate personal data.</li>
        <li>Opt out of targeted advertising or certain data sharing definitions.</li>
        <li>Appeal a denied request where state law provides appeal rights.</li>
    </ul>

    <h2 class="text-xl font-semibold">2. How To Submit A Request</h2>
    <p class="text-slate-700">Submit requests by emailing <a class="underline" href="mailto:<?php echo htmlspecialchars($site['contact_email'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($site['contact_email'], ENT_QUOTES, 'UTF-8'); ?></a> with subject line "US Privacy Request". Include your state of residence, request type, and details that help us locate relevant records. If your request is about a specific interaction, include the date and page URL when possible.</p>

    <h2 class="text-xl font-semibold">3. Verification</h2>
    <p class="text-slate-700">Before processing certain requests, we may need to verify your identity to protect user data. Verification steps are proportionate to request sensitivity and may include confirming control of the email used for the request and collecting minimal additional details needed to authenticate the requester.</p>

    <h2 class="text-xl font-semibold">4. Authorized Agents</h2>
    <p class="text-slate-700">Where state law allows, you may designate an authorized agent to submit requests on your behalf. We may require documentation that demonstrates valid authorization and may still request verification directly from the consumer where legally permitted.</p>

    <h2 class="text-xl font-semibold">5. Response Timing</h2>
    <p class="text-slate-700">We aim to respond within legally required timeframes. If a request is complex, we may extend timing where law allows and provide notice of the extension. If we deny all or part of a request, we provide a reason consistent with applicable law and explain appeal options when required.</p>

    <h2 class="text-xl font-semibold">6. Opt Out Signals</h2>
    <p class="text-slate-700">Some state frameworks recognize browser or platform based opt out preference signals. Where such obligations apply and technical support is available, we evaluate and implement compatible controls. Signal behavior may vary by browser, device, and legal scope.</p>

    <h2 class="text-xl font-semibold">7. Non-Discrimination</h2>
    <p class="text-slate-700">AI Law Guide does not discriminate against users for exercising applicable privacy rights. This means we do not deny core access or apply unjustified penalties solely because a user submitted a valid privacy request.</p>

    <h2 class="text-xl font-semibold">8. Contact</h2>
    <p class="text-slate-700">For US privacy questions or requests, use <a class="underline" href="mailto:<?php echo htmlspecialchars($site['contact_email'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($site['contact_email'], ENT_QUOTES, 'UTF-8'); ?></a>. For broader context, review our Privacy Policy, Cookie Policy, and GDPR page.</p>

    <h2 class="text-xl font-semibold">9. Data Categories In Consumer Requests</h2>
    <p class="text-slate-700">Depending on your interaction with this site, records in scope for a privacy request may include contact details you provided, communication records, technical usage information, cookie preference signals, and service integrity logs. We do not intentionally collect unnecessary sensitive categories through ordinary site use. Scope of response depends on legal applicability and whether records can be reasonably linked to the verified requester.</p>

    <h2 class="text-xl font-semibold">10. Data Use Purposes</h2>
    <p class="text-slate-700">Data may be used for site operation, security, troubleshooting, content improvement, communication handling, and where active, advertising related reporting and fraud prevention. We aim to keep processing aligned with clear operational needs. When state law requires notice or opt out for particular use categories, we incorporate those controls as part of policy and implementation updates.</p>

    <h2 class="text-xl font-semibold">11. Sharing And Targeted Advertising Context</h2>
    <p class="text-slate-700">Certain analytics or advertising workflows may be classified as sharing or targeted advertising under specific state definitions even when no direct sale of a customer list occurs. If such classifications apply, we provide ways to submit opt out requests. Because definitions vary by state and evolve through rulemaking, implementation language may be updated over time to maintain compliance alignment.</p>

    <h2 class="text-xl font-semibold">12. Deletion Request Exceptions</h2>
    <p class="text-slate-700">When deletion requests are valid, we aim to delete eligible data. However, laws may allow retention for security purposes, legal obligations, fraud prevention, or internal operations reasonably aligned with user expectations. If all or part of a deletion request cannot be completed due to a legal exception, we provide an explanation consistent with applicable requirements.</p>

    <h2 class="text-xl font-semibold">13. Appeal Process</h2>
    <p class="text-slate-700">If a request is denied and state law provides an appeal right, you may submit an appeal by replying to the decision email and including additional context or evidence. Appeals are reviewed by a separate internal review step where practical. We provide a written outcome and, where required, information on further complaint channels available under state law.</p>

    <h2 class="text-xl font-semibold">14. Sensitive Data And Minors</h2>
    <p class="text-slate-700">Our site is intended for general informational audiences and is not intentionally directed to children. We do not knowingly process sensitive personal data for unrelated profiling purposes through normal publication operations. If you believe inappropriate data was collected, contact us promptly so we can investigate and take corrective action where needed.</p>

    <h2 class="text-xl font-semibold">15. Request Quality And Practical Tips</h2>
    <p class="text-slate-700">To reduce delays, include your state, request type, and the email address used when contacting us. If you are requesting correction, identify the specific data element and proposed correction. If requesting access or deletion, provide enough detail to locate records without sending unnecessary sensitive information. Clear requests improve processing speed and help us maintain accurate records of rights handling.</p>

    <h2 class="text-xl font-semibold">16. Policy Updates</h2>
    <p class="text-slate-700">US state privacy law is evolving quickly. We update this page as legal definitions, implementation guidance, or operational practices change. Material updates are reflected in the Last updated date at the top of the page. Continued site use after updates means current policy language applies to future interactions, subject to non waivable legal rights.</p>

    <h2 class="text-xl font-semibold">17. Multi-State Complexity</h2>
    <p class="text-slate-700">US privacy compliance involves overlapping but non identical state rules. Definitions, exemptions, and enforcement details can differ in meaningful ways. For this reason, this page provides a practical rights framework rather than claiming one static rulebook for every state. We update handling procedures as statutory amendments and attorney general guidance evolve, and we encourage users to include state context in requests to support accurate responses.</p>

    <h2 class="text-xl font-semibold">18. Continuous Review Commitment</h2>
    <p class="text-slate-700">We review this page alongside our Privacy Policy and Cookie Policy as part of routine governance maintenance. If we introduce new tools, alter ad workflows, or change request handling methods, we update disclosures accordingly. This commitment helps align what we publish with how we operate and supports trust for readers, partners, and compliance reviewers.</p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

