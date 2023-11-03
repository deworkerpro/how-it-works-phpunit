<?php

declare(strict_types=1);

use Test\AssertException;

use function Test\normalizeEmailSimpleTest;
use function Test\normalizeEmailSuffixTest;
use function Test\normalizeEmailDashedSuffixTest;
use function Test\normalizeEmailDoubleSuffixTest;
use function Test\normalizeEmailDashedMailTest;

require_once __DIR__ . '/../vendor/autoload.php';

$tests = [
    normalizeEmailSimpleTest(...),
    normalizeEmailSuffixTest(...),
    normalizeEmailDashedSuffixTest(...),
    normalizeEmailDoubleSuffixTest(...),
    normalizeEmailDashedMailTest(...),
];

$success = true;

foreach ($tests as $function) {
    try {
        $function();
    } catch (AssertException $exception) {
        $success = false;
        echo 'FAIL: ' . $exception->getMessage() . PHP_EOL;
    }
}

exit($success ? 0 : 1);
