<?php

declare(strict_types=1);

namespace Test;

use ReflectionClass;
use ReflectionMethod;
use Throwable;

final class TestSuite
{
    private array $testClasses = [];

    public function addTestFile(string $file): void
    {
        $beforeClassesCount = count(get_declared_classes());
        require $file;
        $newClasses = array_slice(get_declared_classes(), $beforeClassesCount);

        foreach ($newClasses as $class) {
            if (!is_a($class, TestCase::class, true)) {
                continue;
            }
            $this->testClasses[] = $class;
        }
    }

    public function run(): TestResult
    {
        $pass = [];
        $incomplete = [];
        $failure = [];
        $error = [];

        foreach ($this->testClasses as $class) {
            $classRef = new ReflectionClass($class);

            foreach ($classRef->getMethods(ReflectionMethod::IS_PUBLIC) as $methodRef) {
                if (!str_starts_with($methodRef->getName(), 'test')) {
                    continue;
                }

                $test = new $class($methodRef->getName());

                try {
                    $test->run();
                    echo "\033[1;0m.\033[0m";
                    $pass[] = $test;
                } catch (IncompleteTestException $exception) {
                    echo "\033[1;33mI\033[0m";
                    $incomplete[] = new TestFailure($test, $exception);
                } catch (AssertException $exception) {
                    echo "\033[30;41mF\033[0m";
                    $failure[] = new TestFailure($test, $exception);
                } catch (Throwable $exception) {
                    echo "\033[30;41mE\033[0m";
                    $error[] = new TestFailure($test, $exception);
                }
            }
        }

        return new TestResult(
            pass: $pass,
            incomplete: $incomplete,
            failure: $failure,
            error: $error,
        );
    }
}
