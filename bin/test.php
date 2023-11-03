<?php

declare(strict_types=1);

use function App\normalizeEmail;

require_once __DIR__ . '/../src/normalizeEmail.php';

$success = true;

$expected = 'mail@app.test';
$actual = normalizeEmail('mail@app.test');

if ($actual !== $expected) {
    $success = false;
    echo sprintf('Actual value "%s" is not equal to "%s"', $actual, $expected) . PHP_EOL;
}

$expected = 'mail@app.test';
$actual = normalizeEmail('mail+suffix@app.test');

if ($actual !== $expected) {
    $success = false;
    echo sprintf('Actual value "%s" is not equal to "%s"', $actual, $expected) . PHP_EOL;
}

$expected = 'mail@app.test';
$actual = normalizeEmail('mail+dashed-suffix@app.test');

if ($actual !== $expected) {
    $success = false;
    echo sprintf('Actual value "%s" is not equal to "%s"', $actual, $expected) . PHP_EOL;
}

$expected = 'mail@app.test';
$actual = normalizeEmail('mail+double+suffix@app.test');

if ($actual !== $expected) {
    $success = false;
    echo sprintf('Actual value "%s" is not equal to "%s"', $actual, $expected) . PHP_EOL;
}

$expected = 'dashed-mail@app.test';
$actual = normalizeEmail('dashed-mail+suffix@app.test');

if ($actual !== $expected) {
    $success = false;
    echo sprintf('Actual value "%s" is not equal to "%s"', $actual, $expected) . PHP_EOL;
}

exit($success ? 0 : 1);
