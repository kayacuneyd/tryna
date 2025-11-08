<?php
require_once __DIR__ . '/includes/config.php';

$supportedLangs = SUPPORTED_LANGS;
$defaultLang = DEFAULT_LANG;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$path = rtrim($uri, '/') ?: '/';

// Handle API requests first
if (strpos($path, '/api/') === 0) {
    $apiFile = __DIR__ . $uri;
    error_log("API Request - Path: $path, File: $apiFile, Exists: " . (file_exists($apiFile) ? 'yes' : 'no'));
    
    if (file_exists($apiFile)) {
        require $apiFile;
        return true;
    }
    
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'API endpoint not found',
        'path' => $path,
        'file' => $apiFile,
        'debug' => true
    ]);
    return true;
}

// Handle assets and other static files
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|webp|svg|ico|woff|woff2|ttf|pdf)$/i', $path)) {
    $filePath = __DIR__ . $uri;
    if (file_exists($filePath)) {
        return false; // Let PHP serve the file
    }
    http_response_code(404);
    return true;
}

// Serve existing files (assets, php endpoints) directly.
$absolutePath = realpath(__DIR__ . $uri);
if ($uri !== '/' && $absolutePath && is_file($absolutePath)) {
    return false;
}

parse_str($_SERVER['QUERY_STRING'] ?? '', $queryParams);
$segments = array_values(array_filter(explode('/', $path)));

// Allow language-prefixed asset requests like /en/assets/* to resolve correctly.
if (!empty($segments)) {
    $langCandidate = strtolower($segments[0]);
    if (in_array($langCandidate, $supportedLangs, true) && isset($segments[1])) {
        $allowedRoots = ['assets'];
        $assetRoot = realpath(__DIR__ . '/assets');
        $requestedRoot = $segments[1];

        if (in_array($requestedRoot, $allowedRoots, true) && $assetRoot) {
            $localizedPath = '/' . implode('/', array_slice($segments, 1));
            $absoluteLocalizedPath = realpath(__DIR__ . $localizedPath);

            if (
                $absoluteLocalizedPath &&
                strncmp($absoluteLocalizedPath, $assetRoot, strlen($assetRoot)) === 0 &&
                is_file($absoluteLocalizedPath)
            ) {
                if (!headers_sent()) {
                    $mimeType = 'application/octet-stream';
                    if (function_exists('mime_content_type')) {
                        $detected = mime_content_type($absoluteLocalizedPath);
                        if ($detected) {
                            $mimeType = $detected;
                        }
                    } elseif (class_exists('finfo')) {
                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                        $detected = $finfo->file($absoluteLocalizedPath);
                        if ($detected) {
                            $mimeType = $detected;
                        }
                    }
                    header('Content-Type: ' . $mimeType);
                }
                readfile($absoluteLocalizedPath);
                return true;
            }
        }
    }
}

if (!$segments) {
    header("Location: /{$defaultLang}/", true, 302);
    exit;
}

$lang = strtolower($segments[0]);

if (!in_array($lang, $supportedLangs, true)) {
    // Let unknown static files (e.g., favicon.ico) fall through to default handling.
    if (str_contains($lang, '.')) {
        return false;
    }

    $suffix = implode('/', $segments);
    $suffix = $suffix ? '/' . $suffix : '';
    header("Location: /{$defaultLang}{$suffix}", true, 302);
    exit;
}

$rest = array_slice($segments, 1);
$script = null;
$params = ['lang' => $lang];

switch ($rest[0] ?? '') {
    case '':
        $script = 'index.php';
        break;
    case 'portfolio':
        if (!empty($rest[1])) {
            $script = 'case-study.php';
            $params['slug'] = $rest[1];
        } else {
            $script = 'portfolio.php';
        }
        break;
    case 'about':
        $script = 'about.php';
        break;
    case 'services':
        $script = 'services.php';
        break;
    case 'contact':
        $script = 'contact.php';
        break;
    default:
        http_response_code(404);
        echo 'Page not found';
        return true;
}

$_GET = array_merge($queryParams, $params);
$_REQUEST = array_merge($_REQUEST, $_GET);

require __DIR__ . '/' . $script;
return true;
