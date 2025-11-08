<?php
echo "<h1>Pexels API Test</h1>";
echo "<p>Testing API endpoint directly...</p>";

// Simulate the API call
$_GET['page'] = 1;
$_GET['per_page'] = 5;
$_GET['collection_id'] = 'xdljarh';

ob_start();
require_once __DIR__ . '/api/pexels.php';
$output = ob_get_clean();

echo "<h2>API Output:</h2>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";
?>