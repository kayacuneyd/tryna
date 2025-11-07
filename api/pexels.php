<?php
require_once __DIR__ . '/../includes/config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$page = max(1, (int) ($_GET['page'] ?? 1));
$per_page = min(80, max(1, (int) ($_GET['per_page'] ?? 15)));
$category = isset($_GET['category']) ? preg_replace('/[^a-z0-9-]/i', '', $_GET['category']) : 'all';

$collection_id = isset($_GET['collection_id']) ? preg_replace('/[^a-z0-9_-]/i', '', $_GET['collection_id']) : PEXELS_COLLECTION_ID;

$baseHeaders = [
    'Authorization: ' . PEXELS_API_KEY,
];

if ($collection_id) {
    $url = "https://api.pexels.com/v1/collections/{$collection_id}?per_page={$per_page}&page={$page}";
    $raw = pexels_request($url, $baseHeaders);
    if (!$raw['ok']) {
        respond_with_error($raw['status'], 'Failed to fetch photos from Pexels collection', [
            'details' => $raw['error'] ?: null,
        ]);
    }

    $decoded = json_decode($raw['body'], true);
    if (!isset($decoded['media'])) {
        respond_with_error(500, 'Invalid collection response');
    }

    $photos = array_values(array_filter($decoded['media'], function ($item) {
        return ($item['type'] ?? 'Photo') === 'Photo';
    }));

    if ($category !== 'all') {
        $needle = strtolower($category);
        $photos = array_values(array_filter($photos, function ($photo) use ($needle) {
            $searchSpace = strtolower(($photo['alt'] ?? '') . ' ' . ($photo['url'] ?? ''));
            return strpos($searchSpace, $needle) !== false;
        }));
    }

    echo json_encode([
        'page' => $decoded['page'] ?? $page,
        'per_page' => $per_page,
        'photos' => $photos,
        'source' => 'collection',
        'collection_id' => $collection_id,
    ]);
    exit;
}

$query = PEXELS_PHOTOGRAPHER;
if ($category !== 'all') {
    $query .= ' ' . $category;
}

$url = 'https://api.pexels.com/v1/search?query=' . urlencode($query) . "&per_page={$per_page}&page={$page}";
$raw = pexels_request($url, $baseHeaders);

if ($raw['ok']) {
    echo $raw['body'];
    exit;
}

respond_with_error($raw['status'], 'Failed to fetch photos from Pexels', [
    'details' => $raw['error'] ?: null,
]);

function pexels_request(string $url, array $headers): array
{
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($headers, [
            'Accept: application/json',
            'User-Agent: Enes-Portfolio/1.0',
        ]));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return format_http_result($response, $http_code, $error);
    }

    if (filter_var(ini_get('allow_url_fopen'), FILTER_VALIDATE_BOOLEAN)) {
        $headerString = implode("\r\n", array_merge($headers, [
            'Accept: application/json',
            'User-Agent: Enes-Portfolio/1.0',
        ]));
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => $headerString,
                'ignore_errors' => true,
                'timeout' => 15,
                'protocol_version' => 1.1,
            ],
        ]);
        $response = @file_get_contents($url, false, $context);
        $http_code = parse_response_code($http_response_header ?? []);
        $error = $response === false ? 'HTTP request failed (fopen wrapper)' : '';

        return format_http_result($response, $http_code, $error);
    }

    return socket_http_request($url, $headers);
}

function socket_http_request(string $url, array $headers): array
{
    $parts = parse_url($url);
    if (!$parts || empty($parts['host'])) {
        return ['ok' => false, 'status' => 500, 'body' => '', 'error' => 'Invalid URL'];
    }

    $scheme = $parts['scheme'] ?? 'https';
    $host = $parts['host'];
    $path = ($parts['path'] ?? '/') . (isset($parts['query']) ? '?' . $parts['query'] : '');
    $port = $parts['port'] ?? ($scheme === 'https' ? 443 : 80);
    $transport = ($scheme === 'https' ? 'ssl' : 'tcp') . "://{$host}:{$port}";

    $context = stream_context_create($scheme === 'https' ? [
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
            'allow_self_signed' => false,
        ],
    ] : []);

    $fp = @stream_socket_client($transport, $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $context);
    if (!$fp) {
        return ['ok' => false, 'status' => 500, 'body' => '', 'error' => $errstr ?: 'Unable to connect to Pexels'];
    }

    $request = "GET {$path} HTTP/1.1\r\n";
    $request .= "Host: {$host}\r\n";
    $request .= "User-Agent: Enes-Portfolio/1.0\r\n";
    $request .= "Accept: application/json\r\n";
    foreach ($headers as $headerLine) {
        $request .= $headerLine . "\r\n";
    }
    $request .= "Connection: close\r\n\r\n";

    fwrite($fp, $request);
    $response = stream_get_contents($fp);
    fclose($fp);

    if ($response === false) {
        return ['ok' => false, 'status' => 500, 'body' => '', 'error' => 'Empty socket response'];
    }

    [$headerText, $body] = explode("\r\n\r\n", $response, 2) + ['', ''];
    $status = parse_response_code(explode("\r\n", $headerText));

    return format_http_result($body, $status, trim($headerText));
}

function parse_response_code(array $headerLines): int
{
    foreach ($headerLines as $line) {
        if (preg_match('#HTTP/\\S+\\s+(\\d{3})#', $line, $match)) {
            return (int) $match[1];
        }
    }
    return 0;
}

function format_http_result($body, int $status, string $error): array
{
    return [
        'ok' => $status === 200 && $body !== false,
        'status' => $status ?: 500,
        'body' => $body ?: '',
        'error' => $status === 200 ? '' : $error,
    ];
}

function respond_with_error(int $status, string $message = 'Failed to fetch photos from Pexels', array $extra = []): void
{
    http_response_code($status);
    $payload = array_filter(array_merge(['error' => $message], $extra), static fn($value) => $value !== null && $value !== '');
    echo json_encode($payload);
    exit;
}
