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

function blogger_cache_root_dir(): string
{
    return dirname(__DIR__) . '/cache';
}

function blogger_cache_dir(string $name): string
{
    $dir = rtrim(blogger_cache_root_dir(), '/') . '/' . trim($name, '/');
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    return $dir;
}

function blogger_read_json_cached(string $url, int $ttlSeconds = 0): array
{
    $cacheDir = blogger_cache_dir('blogger');
    $cacheFile = $cacheDir . '/' . sha1($url) . '.json';
    $cacheForever = $ttlSeconds < 0;

    if (is_file($cacheFile)) {
        $isFresh = $cacheForever || ($ttlSeconds > 0 && (time() - filemtime($cacheFile) < $ttlSeconds));
        if ($isFresh) {
            $cached = @file_get_contents($cacheFile);
            if (is_string($cached) && $cached !== '') {
                blogger_set_last_error('');
                $decoded = json_decode($cached, true);
                if (is_array($decoded)) {
                    return $decoded;
                }
            }
        }
    }

    $data = blogger_read_json($url);
    if (!empty($data)) {
        @file_put_contents($cacheFile, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX);
        return $data;
    }

    if (is_file($cacheFile)) {
        $cached = @file_get_contents($cacheFile);
        if (is_string($cached) && $cached !== '') {
            $decoded = json_decode($cached, true);
            if (is_array($decoded) && !empty($decoded)) {
                blogger_set_last_error('');
                return $decoded;
            }
        }
    }

    return $data;
}

function blogger_cache_ttl(array $site, int $fallback): int
{
    if (!empty($site['blogger_cache_forever'])) {
        return -1;
    }

    $ttl = (int) ($site['blogger_cache_ttl'] ?? 0);
    return $ttl > 0 ? $ttl : $fallback;
}

function blogger_image_cache_dir(): string
{
    return dirname(__DIR__) . '/uploads/blogger';
}

function blogger_image_cache_url(array $site): string
{
    $siteUrl = rtrim((string) ($site['site_url'] ?? ''), '/');
    if ($siteUrl !== '') {
        return $siteUrl . '/uploads/blogger';
    }
    return blogger_base_path($site) . '/uploads/blogger';
}

function blogger_download_binary(string $url): string
{
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'AI Law Guide-ImageCache/1.0');
        $response = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (is_string($response) && $status >= 200 && $status < 300) {
            return $response;
        }
        return '';
    }

    $response = @file_get_contents($url);
    return is_string($response) ? $response : '';
}

function blogger_cache_image(string $url, array $site): string
{
    $url = trim($url);
    if ($url === '' || str_starts_with($url, 'data:')) {
        return $url;
    }

    $downloadUrl = $url;
    if (str_starts_with($url, '//')) {
        $downloadUrl = 'https:' . $url;
    }

    if (!preg_match('#^https?://#i', $downloadUrl)) {
        return $url;
    }

    $path = (string) parse_url($downloadUrl, PHP_URL_PATH);
    $ext = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    if ($ext === '' || !in_array($ext, $allowedExt, true)) {
        $ext = 'jpg';
    }

    $hash = sha1($url);
    $fileName = $hash . '.' . $ext;
    $cacheDir = blogger_image_cache_dir();
    if (!is_dir($cacheDir)) {
        @mkdir($cacheDir, 0755, true);
    }
    $filePath = rtrim($cacheDir, '/') . '/' . $fileName;

    if (!is_file($filePath)) {
        $data = blogger_download_binary($downloadUrl);
        if ($data !== '') {
            @file_put_contents($filePath, $data, LOCK_EX);
        }
    }

    if (is_file($filePath)) {
        return blogger_image_cache_url($site) . '/' . rawurlencode($fileName);
    }

    return $url;
}

function blogger_strip_image_links(string $html): string
{
    if ($html === '') {
        return $html;
    }

    return preg_replace('/<a\b[^>]*>\s*(<img\b[^>]*>)\s*<\/a>/i', '$1', $html);
}

function blogger_localize_html_images(string $html, array $site): string
{
    if ($html === '') {
        return $html;
    }

    return preg_replace_callback('/<img\b[^>]*\bsrc=["\']([^"\']+)["\'][^>]*>/i', function ($matches) use ($site) {
        $tag = $matches[0];
        $src = $matches[1];
        $cached = blogger_cache_image($src, $site);
        if ($cached !== '' && $cached !== $src) {
            $tag = preg_replace('/\bsrc=["\'][^"\']+["\']/i', 'src="' . $cached . '"', $tag, 1);
        }

        if (!preg_match('/\bloading=["\']?/i', $tag)) {
            $tag = preg_replace('/\s*(\/?)>$/', ' loading="lazy"$1>', $tag);
        }

        if (!preg_match('/\bdecoding=["\']?/i', $tag)) {
            $tag = preg_replace('/\s*(\/?)>$/', ' decoding="async"$1>', $tag);
        }

        return $tag;
    }, $html);
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
    if ($thumbnail !== '') {
        $thumbnail = blogger_cache_image($thumbnail, $site);
    }

    $wordCount = max(1, str_word_count($plainText));
    $readMinutes = max(1, (int) ceil($wordCount / 220));

    $labels = $item['labels'] ?? [];
    $category = is_array($labels) && !empty($labels) ? (string) $labels[0] : 'General';
    $categorySlug = blogger_normalize_category_slug($category);

    $authorRaw = $item['author'] ?? [];
    $authorId = (string) ($authorRaw['id'] ?? '');
    $authorName = (string) ($site['author_name'] ?? 'Rahul Beladiya');
    $authorProfile = (string) ($site['author_profile_url'] ?? '');
    $authorProfilePath = (string) ($site['author_profile_path'] ?? '');
    $authorKeySource = (string) ($site['author_slug'] ?? '');
    if ($authorKeySource === '') {
        $authorKeySource = $authorId !== '' ? $authorId : $authorName;
    }
    $authorKey = blogger_normalize_author_key($authorKeySource);
    if ($authorProfilePath === '') {
        $authorProfilePath = $basePath . '/author/' . rawurlencode($authorKey);
    }

    $author = [
        'id' => $authorId,
        'key' => $authorKey,
        'name' => $authorName,
        'avatar' => '',
        'external_url' => $authorProfile,
        'url' => $authorProfilePath,
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

    $cacheTtl = blogger_cache_ttl($site, 3600);
    $data = blogger_read_json_cached($url, $cacheTtl);
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
    $cacheTtl = blogger_cache_ttl($site, 21600);
    $data = blogger_read_json_cached($url, $cacheTtl);
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

    $cacheTtl = blogger_cache_ttl($site, 3600);
    $data = blogger_read_json_cached($url, $cacheTtl);
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

function blogger_select_related_posts(array $posts, string $currentPostId = '', string $categorySlug = '', int $limit = 3): array
{
    if ($limit <= 0) {
        return [];
    }

    $selected = [];
    $seenIds = [];
    $currentPostId = trim($currentPostId);
    $categorySlug = trim($categorySlug);

    if ($categorySlug !== '') {
        foreach ($posts as $post) {
            if (count($selected) >= $limit) {
                break;
            }
            $postId = (string) ($post['id'] ?? '');
            if ($currentPostId !== '' && $postId === $currentPostId) {
                continue;
            }
            if (($post['category_slug'] ?? '') !== $categorySlug) {
                continue;
            }
            if ($postId !== '' && isset($seenIds[$postId])) {
                continue;
            }
            $selected[] = $post;
            if ($postId !== '') {
                $seenIds[$postId] = true;
            }
        }
    }

    foreach ($posts as $post) {
        if (count($selected) >= $limit) {
            break;
        }
        $postId = (string) ($post['id'] ?? '');
        if ($currentPostId !== '' && $postId === $currentPostId) {
            continue;
        }
        if ($postId !== '' && isset($seenIds[$postId])) {
            continue;
        }
        $selected[] = $post;
        if ($postId !== '') {
            $seenIds[$postId] = true;
        }
    }

    return $selected;
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

