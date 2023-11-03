<?php

declare(strict_types=1);

use Test\AssertException;
use Test\IncompleteTestException;
use Test\NormalizeEmailTest;

require_once __DIR__ . '/../vendor/autoload.php';

$tests = [
    NormalizeEmailTest::testSimple(...),
    NormalizeEmailTest::testSuffix(...),
    NormalizeEmailTest::testDashedSuffix(...),
    NormalizeEmailTest::testDoubleSuffix(...),
    NormalizeEmailTest::testDashedMail(...),
];

$success = true;

foreach ($tests as $function) {
    $name = (new ReflectionFunction($function))->getName();

    try {
        $function();
    } catch (IncompleteTestException $exception) {
        echo 'INCOMPLETE ' . $name . PHP_EOL . $exception->getMessage() . PHP_EOL . PHP_EOL;
    } catch (AssertException $exception) {
        $success = false;
        echo 'FAIL ' . $name . PHP_EOL . $exception->getMessage() . PHP_EOL . PHP_EOL;
    } catch (Throwable $exception) {
        $success = false;
        echo 'ERROR ' . $name . PHP_EOL . $exception . PHP_EOL . PHP_EOL;
    }
}

exit($success ? 0 : 1);
