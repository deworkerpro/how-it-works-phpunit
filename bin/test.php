<?php

declare(strict_types=1);

use Test\TestSuite;
use Test\TestSummaryPrinter;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @var iterable<SplFileInfo> $testFiles
 */
$testFiles = new CallbackFilterIterator(
    new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(__DIR__ . '/../tests', FilesystemIterator::SKIP_DOTS)
    ),
    static fn(SplFileInfo $file) => $file->isFile() && str_ends_with($file->getFilename(), 'Test.php')
);

$suite = new TestSuite();

foreach ($testFiles as $testFile) {
    $suite->addTestFile($testFile->getRealPath());
}

$result = $suite->run();

$printer = new TestSummaryPrinter();
$printer->print($result);

exit($result->isSuccess() ? 0 : 1);
