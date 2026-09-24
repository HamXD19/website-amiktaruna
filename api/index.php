<?php

// Ensure writable directories exist in /tmp for Vercel Serverless
$storagePath = '/tmp/storage';
$directories = [
    $storagePath,
    $storagePath . '/app',
    $storagePath . '/app/public',
    $storagePath . '/framework',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/framework/testing',
    $storagePath . '/logs',
    '/tmp/bootstrap-cache',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';

