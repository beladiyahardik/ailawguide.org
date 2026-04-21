<?php
require __DIR__ . '/includes/page-cache.php';
$site = require __DIR__ . '/includes/site.php';
require __DIR__ . '/includes/blogger.php';

$basePath = rtrim((string) ($site['base_path'] ?? '/'), '/');
$postId = (string) ($_GET['id'] ?? $_GET['post_id'] ?? '');

if ($postId !== '') {
    $post = blogger_fetch_post_by_id($site, $postId);
    if ($post !== null) {
        header('Location: ' . $post['url'], true, 301);
        exit;
    }

    header('Location: ' . $basePath . '/blog/post-' . rawurlencode($postId), true, 301);
    exit;
}

header('Location: ' . $basePath . '/', true, 301);
exit;
