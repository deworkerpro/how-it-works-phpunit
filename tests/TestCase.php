<?php

declare(strict_types=1);

namespace Test;

use Throwable;

abstract class TestCase
{
    private readonly string $methodName;
    private ?string $expectedException = null;

    public function __construct(string $methodName)
    {
        $this->methodName = $methodName;
    }

    public function run(): void
    {
        try {
            $this->{$this->methodName}();
            if ($this->expectedException !== null) {
                fail('Exception ' . $this->expectedException . ' is not thrown');
            }
        } catch (AssertException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            if ($this->expectedException !== null) {
                if ($exception::class !== $this->expectedException) {
                    fail('Exception ' . $exception::class . ' is not equal to ' . $this->expectedException);
                }
            } else {
                throw $exception;
            }
        }
    }

    protected function expectException(string $class): void
    {
        $this->expectedException = $class;
    }
}
