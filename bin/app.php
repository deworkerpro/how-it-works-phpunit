<?php

declare(strict_types=1);

use function App\normalizeEmail;

require_once __DIR__ . '/../vendor/autoload.php';

echo 'Email: ' . normalizeEmail('mail+suffix@app.test') . PHP_EOL;
