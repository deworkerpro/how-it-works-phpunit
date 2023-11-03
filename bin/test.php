<?php

declare(strict_types=1);

use Test\AssertException;

use function Test\normalizeEmailSimpleTest;
use function Test\normalizeEmailSuffixTest;
use function Test\normalizeEmailDashedSuffixTest;
use function Test\normalizeEmailDoubleSuffixTest;
use function Test\normalizeEmailDashedMailTest;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    normalizeEmailSimpleTest();
} catch (AssertException $exception) {
    $success = false;
    echo 'FAIL: ' . $exception->getMessage() . PHP_EOL;
}

try {
    normalizeEmailSuffixTest();
} catch (AssertException $exception) {
    $success = false;
    echo 'FAIL: ' . $exception->getMessage() . PHP_EOL;
}

try {
    normalizeEmailDashedSuffixTest();
} catch (AssertException $exception) {
    $success = false;
    echo 'FAIL: ' . $exception->getMessage() . PHP_EOL;
}

try {
    normalizeEmailDoubleSuffixTest();
} catch (AssertException $exception) {
    $success = false;
    echo 'FAIL: ' . $exception->getMessage() . PHP_EOL;
}

try {
    normalizeEmailDashedMailTest();
} catch (AssertException $exception) {
    $success = false;
    echo 'FAIL: ' . $exception->getMessage() . PHP_EOL;
}

exit($success ? 0 : 1);
