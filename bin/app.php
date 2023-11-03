<?php

declare(strict_types=1);

use function App\normalizeEmail;

require_once __DIR__ . '/../src/normalizeEmail.php';

echo 'Email: ' . normalizeEmail('mail+suffix@app.test') . PHP_EOL;
