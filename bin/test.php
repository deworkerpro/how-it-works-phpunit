<?php

declare(strict_types=1);

use Test\AssertException;

use function App\normalizeEmail;
use function Test\assertEquals;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    assertEquals('mail@app.test', normalizeEmail('mail@app.test'));
    assertEquals('mail@app.test', normalizeEmail('mail+suffix@app.test'));
    assertEquals('mail@app.test', normalizeEmail('mail+dashed-suffix@app.test'));
    assertEquals('mail@app.test', normalizeEmail('mail+double+suffix@app.test'));
    assertEquals('dashed-mail@app.test', normalizeEmail('dashed-mail+suffix@app.test'));
} catch (AssertException $exception) {
    $success = false;
    echo 'FAIL: ' . $exception->getMessage() . PHP_EOL;
}

exit($success ? 0 : 1);
