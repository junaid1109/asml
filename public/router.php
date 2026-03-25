<?php
// Get the requested path
$requested = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Build the filesystem path
$file = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, $requested);

// If it's a real file, serve it directly
if (file_exists($file) && is_file($file)) {
    // Determine the MIME type
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'txt' => 'text/plain',
        'html' => 'text/html',
        'pdf' => 'application/pdf',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
    ];
    
    $mimeType = $mimeTypes[$ext] ?? 'application/octet-stream';
    
    // Send appropriate headers and serve the file
    header('Content-Type: ' . $mimeType);
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit();
}

// Otherwise let Laravel handle it
require __DIR__ . '/index.php';
