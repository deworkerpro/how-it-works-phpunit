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

$result = $suite->run();

if ($result->isSuccess()) {
    echo "\033[30;42m OK \033[0m" . PHP_EOL;
} else {
    echo "\033[30;41m FAIL \033[0m" . PHP_EOL;
}

echo sprintf(
    "\033[30;43m Pass: %d, Incomplete: %d, Failure: %d, Error: %d \033[0m",
    $result->getPassCount(),
    $result->getIncompleteCount(),
    $result->getFailureCount(),
    $result->getErrorCount(),
) . PHP_EOL;

exit($result->isSuccess() ? 0 : 1);
