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

    public function run(): bool
    {
        $success = true;

        foreach ($this->testClasses as $class) {
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

        return $success;
    }
}
