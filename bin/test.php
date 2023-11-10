<?php

declare(strict_types=1);

use Test\AssertException;
use Test\IncompleteTestException;
use Test\TestCase;

use function Test\loadFileClasses;

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

$success = true;

foreach ($testFiles as $testFile) {
    $classes = loadFileClasses($testFile->getRealPath());

    foreach ($classes as $class) {
        if (!is_a($class, TestCase::class, true)) {
            continue;
        }

        $classRef = new ReflectionClass($class);

        foreach ($classRef->getMethods(ReflectionMethod::IS_PUBLIC) as $methodRef) {
            if (!str_starts_with($methodRef->getName(), 'test')) {
                continue;
            }

            $test = new $class($methodRef->getName());

            try {
                $test->run();
            } catch (IncompleteTestException $exception) {
                echo 'INCOMPLETE ' . $test->getName() . PHP_EOL . $exception->getMessage() . PHP_EOL . PHP_EOL;
            } catch (AssertException $exception) {
                $success = false;
                echo 'FAIL ' . $test->getName() . PHP_EOL . $exception->getMessage() . PHP_EOL . PHP_EOL;
            } catch (Throwable $exception) {
                $success = false;
                echo 'ERROR ' . $test->getName() . PHP_EOL . $exception . PHP_EOL . PHP_EOL;
            }
        }
    }
}

exit($success ? 0 : 1);
