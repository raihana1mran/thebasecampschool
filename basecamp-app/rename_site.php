<?php
$dir = __DIR__ . '/resources/views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$bladeFiles = new RegexIterator($files, '/\.blade\.php$/');

$replacements = [
    'Peak Performance Entry' => 'The Base Camp School',
    'Peak Performance' => 'The Base Camp School',
    'EtherMed LMS' => 'The Base Camp School',
    'EtherMed' => 'The Base Camp School',
    'Ethereal Archive' => 'The Base Camp School',
    'Lumine LMS' => 'The Base Camp School',
    'MedCore Terminal' => 'The Base Camp School',
    'MedCore' => 'The Base Camp School',
    'Aether Institute' => 'The Base Camp School',
    'MedPrep Ethereal' => 'The Base Camp School',
    'MedCloud Academy' => 'The Base Camp School',
    'Luminous Platform' => 'The Base Camp School',
];

foreach ($bladeFiles as $file) {
    if (!$file->isFile()) continue;
    $path = $file->getRealPath();
    $content = file_get_contents($path);
    $newContent = str_replace(array_keys($replacements), array_values($replacements), $content);
    if ($content !== $newContent) {
        file_put_contents($path, $newContent);
        echo "Updated $path\n";
    }
}
