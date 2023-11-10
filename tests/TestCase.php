<?php

declare(strict_types=1);

namespace Test;

use Throwable;

abstract class TestCase extends Assert
{
    private readonly string $methodName;
    private readonly int|string|null $dataName;
    private readonly array $data;
    private ?string $expectedException = null;

    public function __construct(string $methodName, int|string|null $dataName, array $data)
    {
        $this->methodName = $methodName;
        $this->dataName = $dataName;
        $this->data = $data;
    }

    public function run(EventEmitter $emitter): void
    {
        try{
            try {
                $this->{$this->methodName}(...$this->data);
                if ($this->expectedException !== null) {
                    self::fail('Exception ' . $this->expectedException . ' is not thrown');
                }
            } catch (AssertException $exception) {
                throw $exception;
            } catch (Throwable $exception) {
                if ($this->expectedException !== null) {
                    if ($exception::class !== $this->expectedException) {
                        self::fail('Exception ' . $exception::class . ' is not equal to ' . $this->expectedException);
                    }
                } else {
                    throw $exception;
                }
            }
            $emitter->testPass($this);
        } catch (IncompleteTestException $exception) {
            $emitter->testIncomplete($this, $exception);
        } catch (AssertException $exception) {
            $emitter->testFailure($this, $exception);
        } catch (Throwable $exception) {
            $emitter->testError($this, $exception);
        }
    }

    public function getName(): string
    {
        return $this::class . '::' . $this->methodName . ($this->dataName !== null ? ' with #' . $this->dataName : '');
    }

    protected function expectException(string $class): void
    {
        $this->expectedException = $class;
    }

    protected static function markTestIncomplete(string $reason = ''): void
    {
        throw new IncompleteTestException($reason);
    }
}
