<?php

declare(strict_types=1);

use Test\TestSuite;

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

$success = $suite->run();

exit($success ? 0 : 1);
