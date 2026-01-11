<?php

return [
    'name' => 'OWASP Top 10 Training App',
    'version' => '1.0.0',
    'debug' => false, // Set to true for A05 vulnerability demonstration
    'session_name' => 'owasp_training_session',
    'session_lifetime' => 3600, // 1 hour
    'log_path' => __DIR__ . '/../storage/logs/app.log',
    'upload_path' => __DIR__ . '/../storage/uploads',
    'base_url' => '/',
];
