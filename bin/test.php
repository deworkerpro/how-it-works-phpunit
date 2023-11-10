<?php

declare(strict_types=1);

use Test\AssertException;
use Test\IncompleteTestException;
use Test\TestCase;

use function Test\loadFileClasses;
use function Test\fail;

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

            $name = $classRef->getName() . '::' . $methodRef->getName();

            $object = new $class();
            $methodName = $methodRef->getName();

            try {
                try {
                    $object->$methodName();
                    if (($expectedExceptionClass = $object->getExpectedException()) !== null) {
                        fail('Exception ' . $expectedExceptionClass . ' is not thrown');
                    }
                } catch (AssertException $exception) {
                    throw $exception;
                } catch (Throwable $exception) {
                    if (($expectedExceptionClass = $object->getExpectedException()) !== null) {
                        if ($exception::class !== $expectedExceptionClass) {
                            fail('Exception ' . $exception::class . ' is not equal to ' . $expectedExceptionClass);
                        }
                    } else {
                        throw $exception;
                    }
                }
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
