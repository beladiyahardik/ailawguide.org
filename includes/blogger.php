<?php

function blogger_base_path(array $site): string
{
    $basePath = (string) ($site['base_path'] ?? '');
    return rtrim($basePath, '/');
}

function blogger_set_last_error(string $message): void
{
    $GLOBALS['BLOGGER_LAST_ERROR'] = $message;
}

function blogger_last_error(): string
{
    return (string) ($GLOBALS['BLOGGER_LAST_ERROR'] ?? '');
}

function blogger_extract_first_image(string $html): ?string
{
    if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches)) {
        return $matches[1];
    }

    return null;
}

function blogger_normalize_author_key(string $value): string
{
    $value = strtolower(trim($value));
    $value = preg_replace('/[^a-z0-9]+/', '-', $value);
    $value = trim((string) $value, '-');
    return $value !== '' ? $value : 'author';
}

function blogger_normalize_category_slug(string $value): string
{
    $value = strtolower(trim($value));
    $value = preg_replace('/[^a-z0-9]+/', '-', $value);
    $value = trim((string) $value, '-');
    return $value !== '' ? $value : 'general';
}

function blogger_slugify_title(string $title): string
{
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim((string) $slug, '-');
    return $slug !== '' ? $slug : 'post';
}

function blogger_slug_from_url(string $url): string
{
    $path = parse_url($url, PHP_URL_PATH);
    if (!is_string($path) || $path === '') {
        return 'post';
    }

    $segments = explode('/', trim($path, '/'));
    $slug = end($segments);

    if (!is_string($slug) || $slug === '') {
        return 'post';
    }

    $slug = preg_replace('/\.html?$/i', '', $slug);
    $slug = trim((string) $slug);

    return $slug !== '' ? $slug : 'post';
}

function blogger_substr(string $text, int $start, int $length): string
{
    if (function_exists('mb_substr')) {
        return (string) mb_substr($text, $start, $length);
    }

    return (string) substr($text, $start, $length);
}

function blogger_strlen(string $text): int
{
    if (function_exists('mb_strlen')) {
        return (int) mb_strlen($text);
    }

    return (int) strlen($text);
}

function blogger_decode_json(string $response): array
{
    $decoded = json_decode($response, true);
    if (!is_array($decoded)) {
        blogger_set_last_error('Blogger API returned invalid JSON.');
        return [];
    }

    if (isset($decoded['error']['message']) && is_string($decoded['error']['message'])) {
        blogger_set_last_error('Blogger API error: ' . $decoded['error']['message']);
    }

    return $decoded;
}

function blogger_read_json(string $url): array
{
    blogger_set_last_error('');

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'AI Law Guide-BloggerClient/1.0');
        $response = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr = curl_error($ch);
        curl_close($ch);

        if (is_string($response) && $status >= 200 && $status < 300) {
            return blogger_decode_json($response);
        }

        if ($curlErr !== '') {
            blogger_set_last_error('cURL error: ' . $curlErr);
        } elseif (is_string($response) && $response !== '') {
            $decoded = blogger_decode_json($response);
            if (!empty($decoded)) {
                return $decoded;
            }
            blogger_set_last_error('Blogger API HTTP error: ' . $status);
        } else {
            blogger_set_last_error('Blogger API HTTP error: ' . $status);
        }
    }

    $response = @file_get_contents($url);
    if ($response === false) {
        if (blogger_last_error() === '') {
            blogger_set_last_error('Unable to reach Blogger API from this server.');
        }
        return [];
    }

    return blogger_decode_json($response);
}

function blogger_api_url(array $site, string $path, array $params = []): string
{
    $apiKey = (string) ($site['blogger_api_key'] ?? '');
    $query = http_build_query(array_merge($params, ['key' => $apiKey]));
    return 'https://www.googleapis.com/blogger/v3/' . ltrim($path, '/') . '?' . $query;
}

function blogger_map_post(array $item, array $site): array
{
    $title = (string) ($item['title'] ?? 'Untitled');
    $id = (string) ($item['id'] ?? '');
    $content = (string) ($item['content'] ?? '');
    $published = (string) ($item['published'] ?? '');
    $updated = (string) ($item['updated'] ?? $published);
    $publishedTs = strtotime($published);
    $date = $publishedTs !== false ? date('F j, Y', $publishedTs) : '';

    $plainText = trim(strip_tags($content));
    $excerpt = blogger_substr($plainText, 0, 180);
    if (blogger_strlen($plainText) > 180) {
        $excerpt .= '...';
    }

    $slug = blogger_slugify_title($title);
    $basePath = blogger_base_path($site);
    $localUrl = $basePath . '/blog/' . rawurlencode($slug) . '-' . rawurlencode($id);

    $thumbnail = null;
    if (isset($item['images'][0]['url']) && is_string($item['images'][0]['url'])) {
        $thumbnail = $item['images'][0]['url'];
    }

    if ($thumbnail === null) {
        $thumbnail = blogger_extract_first_image($content);
    }

    if ($thumbnail === null) {
        $thumbnail = '';
    }

    $wordCount = max(1, str_word_count($plainText));
    $readMinutes = max(1, (int) ceil($wordCount / 220));

    $labels = $item['labels'] ?? [];
    $category = is_array($labels) && !empty($labels) ? (string) $labels[0] : 'General';
    $categorySlug = blogger_normalize_category_slug($category);

    $authorRaw = $item['author'] ?? [];
    $authorName = (string) ($authorRaw['displayName'] ?? 'AI Law Guide Editorial');
    $authorId = (string) ($authorRaw['id'] ?? '');
    $authorImage = (string) ($authorRaw['image']['url'] ?? '');
    $authorProfile = (string) ($authorRaw['url'] ?? '');
    $authorKeySource = $authorId !== '' ? $authorId : $authorName;
    $authorKey = blogger_normalize_author_key($authorKeySource);

    if ($authorImage === '') {
        $authorImage = $basePath . '/uploads/thumb-content.svg';
    }

    $author = [
        'id' => $authorId,
        'key' => $authorKey,
        'name' => $authorName,
        'avatar' => $authorImage,
        'external_url' => $authorProfile,
        'url' => $basePath . '/author/' . rawurlencode($authorKey),
    ];

    return [
        'id' => $id,
        'title' => $title,
        'slug' => $slug,
        'url' => $localUrl,
        'excerpt' => $excerpt,
        'category' => $category,
        'category_slug' => $categorySlug,
        'category_url' => $basePath . '/category/' . rawurlencode($categorySlug),
        'date' => $date,
        'date_iso' => $published,
        'date_modified_iso' => $updated,
        'read_time' => $readMinutes . ' min read',
        'thumbnail' => $thumbnail,
        'content' => $content,
        'author' => $author,
    ];
}

function blogger_fetch_posts(array $site, int $maxResults = 9): array
{
    $blogId = (string) ($site['blogger_blog_id'] ?? '');
    if ($blogId === '' || (string) ($site['blogger_api_key'] ?? '') === '') {
        blogger_set_last_error('Missing blogger blog ID or API key in includes/site.php.');
        return [];
    }

    $url = blogger_api_url($site, 'blogs/' . rawurlencode($blogId) . '/posts', [
        'maxResults' => $maxResults,
        'fetchImages' => 'true',
        'status' => 'LIVE',
    ]);

    $data = blogger_read_json($url);
    $items = $data['items'] ?? [];

    if (!is_array($items)) {
        if (blogger_last_error() === '') {
            blogger_set_last_error('No published posts returned from Blogger API.');
        }
        return [];
    }

    $posts = [];
    foreach ($items as $item) {
        if (is_array($item)) {
            $posts[] = blogger_map_post($item, $site);
        }
    }

    return $posts;
}

function blogger_fetch_blog_info(array $site): array
{
    static $cache = [];

    $blogId = (string) ($site['blogger_blog_id'] ?? '');
    $apiKey = (string) ($site['blogger_api_key'] ?? '');
    if ($blogId === '' || $apiKey === '') {
        blogger_set_last_error('Missing blogger blog ID or API key in includes/site.php.');
        return [];
    }

    $cacheKey = $blogId . '|' . $apiKey;
    if (isset($cache[$cacheKey]) && is_array($cache[$cacheKey])) {
        return $cache[$cacheKey];
    }

    $url = blogger_api_url($site, 'blogs/' . rawurlencode($blogId));
    $data = blogger_read_json($url);
    if (!is_array($data) || !isset($data['id'])) {
        if (blogger_last_error() === '') {
            blogger_set_last_error('Unable to fetch blog info from Blogger API.');
        }
        $cache[$cacheKey] = [];
        return [];
    }

    $mapped = [
        'id' => (string) ($data['id'] ?? ''),
        'name' => (string) ($data['name'] ?? ''),
        'description' => trim((string) ($data['description'] ?? '')),
        'url' => (string) ($data['url'] ?? ''),
    ];

    $cache[$cacheKey] = $mapped;
    return $mapped;
}

function blogger_blog_description(array $site, string $fallback = ''): string
{
    $blogInfo = blogger_fetch_blog_info($site);
    $description = trim((string) ($blogInfo['description'] ?? ''));
    if ($description !== '') {
        return $description;
    }

    if ($fallback !== '') {
        return $fallback;
    }

    return trim((string) ($site['tagline'] ?? ''));
}

function blogger_fetch_post_by_id(array $site, string $postId): ?array
{
    $blogId = (string) ($site['blogger_blog_id'] ?? '');
    if ($blogId === '' || $postId === '' || (string) ($site['blogger_api_key'] ?? '') === '') {
        blogger_set_last_error('Missing blog ID, post ID, or API key.');
        return null;
    }

    $url = blogger_api_url($site, 'blogs/' . rawurlencode($blogId) . '/posts/' . rawurlencode($postId), [
        'fetchImages' => 'true',
        'status' => 'LIVE',
    ]);

    $data = blogger_read_json($url);
    if (empty($data) || !is_array($data) || !isset($data['id'])) {
        if (blogger_last_error() === '') {
            blogger_set_last_error('Post not found from Blogger API for ID: ' . $postId);
        }
        return null;
    }

    return blogger_map_post($data, $site);
}

function blogger_find_author(array $posts, string $authorKey): ?array
{
    foreach ($posts as $post) {
        $postAuthor = $post['author'] ?? [];
        if (($postAuthor['key'] ?? '') === $authorKey) {
            return $postAuthor;
        }
    }

    return null;
}

function blogger_filter_posts_by_author(array $posts, string $authorKey): array
{
    $result = [];
    foreach ($posts as $post) {
        $postAuthor = $post['author'] ?? [];
        if (($postAuthor['key'] ?? '') === $authorKey) {
            $result[] = $post;
        }
    }

    return $result;
}

function blogger_filter_posts_by_category(array $posts, string $categorySlug): array
{
    $result = [];
    foreach ($posts as $post) {
        if (($post['category_slug'] ?? '') === $categorySlug) {
            $result[] = $post;
        }
    }

    return $result;
}

function blogger_resolve_category_name(array $posts, string $categorySlug): string
{
    foreach ($posts as $post) {
        if (($post['category_slug'] ?? '') === $categorySlug) {
            return (string) ($post['category'] ?? 'General');
        }
    }

    return 'General';
}

