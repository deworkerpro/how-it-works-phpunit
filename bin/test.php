<?php

declare(strict_types=1);

use function App\normalizeEmail;

require_once __DIR__ . '/../src/normalizeEmail.php';

$success = true;

if ('mail@app.test' !== normalizeEmail('mail@app.test')) {
    $success = false;
    echo 'Values are not equal' . PHP_EOL;
}

if ('mail@app.test' !== normalizeEmail('mail+suffix@app.test')) {
    $success = false;
    echo 'Values are not equal' . PHP_EOL;
}

if ('mail@app.test' !== normalizeEmail('mail+dashed-suffix@app.test')) {
    $success = false;
    echo 'Values are not equal' . PHP_EOL;
}

if ('mail@app.test' !== normalizeEmail('mail+double+suffix@app.test')) {
    $success = false;
    echo 'Values are not equal' . PHP_EOL;
}

if ('dashed-mail@app.test' !== normalizeEmail('dashed-mail+suffix@app.test')) {
    $success = false;
    echo 'Values are not equal' . PHP_EOL;
}

exit($success ? 0 : 1);
