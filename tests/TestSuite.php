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

    public function run(EventEmitter $emitter): TestResult
    {
        $pass = [];
        $incomplete = [];
        $failure = [];
        $error = [];

        $emitter->testsStart();

        foreach ($this->testClasses as $class) {
            $classRef = new ReflectionClass($class);

            foreach ($classRef->getMethods(ReflectionMethod::IS_PUBLIC) as $methodRef) {
                if (!str_starts_with($methodRef->getName(), 'test')) {
                    continue;
                }

                $test = new $class($methodRef->getName());

                try {
                    $test->run();
                    $pass[] = $test;
                    $emitter->testPass($test);
                } catch (IncompleteTestException $exception) {
                    $incomplete[] = new TestFailure($test, $exception);
                    $emitter->testIncomplete($test, $exception);
                } catch (AssertException $exception) {
                    $failure[] = new TestFailure($test, $exception);
                    $emitter->testFailure($test, $exception);
                } catch (Throwable $exception) {
                    $error[] = new TestFailure($test, $exception);
                    $emitter->testError($test, $exception);
                }
            }
        }

        $emitter->testsComplete();

        return new TestResult(
            pass: $pass,
            incomplete: $incomplete,
            failure: $failure,
            error: $error,
        );
    }
}
