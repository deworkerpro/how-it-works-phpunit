<?php

declare(strict_types=1);

use Test\AssertException;
use Test\IncompleteTestException;

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
        $classRef = new ReflectionClass($class);

        foreach ($classRef->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC) as $methodRef) {
            if (!str_starts_with($methodRef->getName(), 'test')) {
                continue;
            }

            $name = $classRef->getName() . '::' . $methodRef->getName();
            $methodName = $methodRef->getName();

            try {
                $class::$methodName();
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
    }
}

exit($success ? 0 : 1);
