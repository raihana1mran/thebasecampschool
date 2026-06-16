<?php
$files = [
    __DIR__ . '/resources/views/dashboard.blade.php',
    __DIR__ . '/resources/views/learning.blade.php',
    __DIR__ . '/resources/views/tma.blade.php',
    __DIR__ . '/resources/views/mocktests.blade.php'
];

foreach ($files as $path) {
    if (!file_exists($path)) {
        continue;
    }
    $content = file_get_contents($path);
    // Find <aside ...> up to </aside>
    $pattern = '/<aside[^>]*>.*?<\/aside>\s*/is';
    
    $replaced = preg_replace($pattern, '<x-student-sidebar />'."\n", $content);
    if ($replaced !== null && $replaced !== $content) {
        file_put_contents($path, $replaced);
        echo "Replaced sidebar in " . basename($path) . "\n";
    }
}
