<?php

declare(strict_types=1);

use Test\AssertException;

use function Test\normalizeEmailTest;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    normalizeEmailTest();
} catch (AssertException $exception) {
    $success = false;
    echo 'FAIL: ' . $exception->getMessage() . PHP_EOL;
}

exit($success ? 0 : 1);
