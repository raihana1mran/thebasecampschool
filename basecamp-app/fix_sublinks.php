<?php
$dir = __DIR__ . '/resources/views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$bladeFiles = new RegexIterator($files, '/\.blade\.php$/');

$urls = [
    'Honor Code' => "{{ url('/admission-policy') }}",
    'Medical Board Registry' => "{{ url('/admission-policy') }}",
    'Accreditation' => "{{ url('/admission-policy') }}",
    'Technical Support' => "{{ url('/contact') }}",
    'Support' => "{{ url('/contact') }}",
    'Contact Archivist' => "{{ url('/contact') }}",
    'Contact Support' => "{{ url('/contact') }}",
    'Privacy Policy' => "{{ url('/privacy') }}",
    'Privacy' => "{{ url('/privacy') }}",
    'Institutional Access' => "{{ url('/about') }}",
    'Faculty' => "{{ url('/about') }}",
    'Research' => "{{ url('/about') }}",
    'Terms of Access' => "{{ url('/terms') }}",
    'Terms of Service' => "{{ url('/terms') }}",
    'Curriculum' => "{{ url('/courses') }}",
    'Student Portal' => "{{ url('/dashboard') }}"
];

foreach ($bladeFiles as $file) {
    if (!$file->isFile()) continue;
    $path = $file->getRealPath();
    $content = file_get_contents($path);
    $original = $content;
    
    foreach ($urls as $text => $url) {
        $content = preg_replace('/(href=\")#(\"[^>]*>\s*' . preg_quote($text, '/') . '\s*<\/a>)/i', '${1}' . $url . '${2}', $content);
    }

    if ($original !== $content) {
        file_put_contents($path, $content);
        echo "Updated links in $path\n";
    }
}
