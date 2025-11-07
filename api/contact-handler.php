<?php
require_once __DIR__ . '/../includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$subject || !$message) {
    http_response_code(422);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$body = "Name: {$name}\nEmail: {$email}\nSubject: {$subject}\nMessage: {$message}";
$headers = 'From: ' . SITE_NAME . ' <no-reply@' . parse_url(SITE_URL, PHP_URL_HOST) . '>' . "\r\n" .
           'Reply-To: ' . $email;

if (@mail('info@turkogluenes.com', 'Website Contact: ' . $subject, $body, $headers)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to send message']);
}
?>