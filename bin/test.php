<?php

declare(strict_types=1);

use function App\normalizeEmail;

require_once __DIR__ . '/../src/normalizeEmail.php';

final class AssertException extends LogicException {}

function assertEquals(string $expected, string $actual): void
{
    if ($actual !== $expected) {
        throw new AssertException(sprintf('Actual value "%s" is not equal to "%s"', $actual, $expected));
    }
}

$success = true;

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
