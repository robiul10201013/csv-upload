<?php

return [
    'temporary_file_upload' => [
        // ...
        'rules' => 'file|mimes:png,jpg,pdf,csv|max:102400', // (100MB max, and only accept PNGs, JPEGs, and PDFs)
    ],
];