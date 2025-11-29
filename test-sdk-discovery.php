#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

echo "=== Testing SDK Discovery ===\n\n";

// Test discovery directly
$basePath = getcwd();
echo "Base path: $basePath\n";

$scanDirs = [
    'mcp',
    'vendor/wachterjohannes/debug-mcp-tools/src',
];

echo "Scan dirs:\n";
foreach ($scanDirs as $dir) {
    $fullPath = "$basePath/$dir";
    echo "  - $dir (exists: " . (is_dir($fullPath) ? 'yes' : 'no') . ")\n";
}
echo "\n";

// Try to build server with discovery
try {
    $server = \Mcp\Server::builder()
        ->setServerInfo('test-server', '1.0.0')
        ->setDiscovery(
            basePath: $basePath,
            scanDirs: $scanDirs,
            excludeDirs: []
        )
        ->build();

    echo "✅ Server built successfully\n";

    // Access the registry to see what was discovered
    $reflection = new ReflectionObject($server);
    echo "\nServer properties:\n";
    foreach ($reflection->getProperties() as $prop) {
        $prop->setAccessible(true);
        echo "  - " . $prop->getName() . ": " . get_class($prop->getValue($server) ?? 'null') . "\n";
    }

} catch (\Exception $e) {
    echo "❌ Error building server: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
