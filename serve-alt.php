<?php
/**
 * Laravel artisan serve alternative for Windows
 * Usage: php serve-alt.php --port=8000
 */

// Parse arguments
$port = 8000;
$host = 'localhost';

foreach ($argv as $arg) {
    if (strpos($arg, '--port=') === 0) {
        $port = (int)explode('=', $arg)[1];
    }
    if (strpos($arg, '--host=') === 0) {
        $host = explode('=', $arg)[1];
    }
}

$publicPath = __DIR__ . '/public';
$routerPath = $publicPath . '/router.php';

// Ensure router exists
if (!file_exists($routerPath)) {
    file_put_contents($routerPath, '<?php
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$requested_file = __DIR__ . $uri;

if ($uri !== "/" && file_exists($requested_file)) {
    return false;
}

require __DIR__ . "/index.php";
');
}

echo "Laravel development server started\n";
echo "Listening on http://{$host}:{$port}\n";
echo "Press Ctrl+C to stop\n\n";

// Start the server
passthru("php -S {$host}:{$port} {$routerPath}");
