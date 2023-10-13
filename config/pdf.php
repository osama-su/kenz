<?php

return [
    'format' => 'A4', // See https://mpdf.github.io/paging/page-size-orientation.html
    'author' => 'John Doe',
    'subject' => 'This Document will explain the whole universe.',
    'keywords' => 'PDF, Laravel, Package, Peace', // Separate values with comma
    'creator' => 'Laravel Pdf',
    'display_mode' => 'fullpage',
    'tempDir' => base_path('/temp/'),
    'examplefont' => [
        'R' => 'arabic-font.ttf',    // regular font
        'B' => 'arabic-font.ttf',          // optional: bold font
        'I' => 'arabic-font-Light.ttf',    // optional: italic font
        'BI' => 'arabic-font.ttf',           // optional: bold-italic font
        'useOTL' => 0xFF,
        'useKashida' => 75,
    ]
];
