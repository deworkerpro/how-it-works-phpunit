<?php

declare(strict_types=1);

use function App\normalizeEmail;

require_once __DIR__ . '/../src/normalizeEmail.php';

if ('mail@app.test' !== normalizeEmail('mail+suffix@app.test')) {
    echo 'Values are not equal' . PHP_EOL;
}
