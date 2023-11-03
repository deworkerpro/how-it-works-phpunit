<?php

declare(strict_types=1);

use function App\normalizeEmail;

require_once __DIR__ . '/../src/normalizeEmail.php';

function assertEquals(string $expected, string $actual, bool &$success): void
{
    if ($actual !== $expected) {
        $success = false;
        echo sprintf('Actual value "%s" is not equal to "%s"', $actual, $expected) . PHP_EOL;
    }
}

$success = true;

assertEquals('mail@app.test', normalizeEmail('mail@app.test'), $success);
assertEquals('mail@app.test', normalizeEmail('mail+suffix@app.test'), $success);
assertEquals('mail@app.test', normalizeEmail('mail+dashed-suffix@app.test'), $success);
assertEquals('mail@app.test', normalizeEmail('mail+double+suffix@app.test'), $success);
assertEquals('dashed-mail@app.test', normalizeEmail('dashed-mail+suffix@app.test'), $success);

exit($success ? 0 : 1);
