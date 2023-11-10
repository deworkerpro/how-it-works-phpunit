<?php

declare(strict_types=1);

namespace Test;

use ReflectionClass;
use ReflectionMethod;

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

    public function run(EventEmitter $emitter): void
    {
        $emitter->testsStart();

        foreach ($this->testClasses as $class) {
            $classRef = new ReflectionClass($class);

            foreach ($classRef->getMethods(ReflectionMethod::IS_PUBLIC) as $methodRef) {
                if (!str_starts_with($methodRef->getName(), 'test')) {
                    continue;
                }

                $test = new $class($methodRef->getName());
                $test->run($emitter);
            }
        }

        $emitter->testsComplete();
    }
}
