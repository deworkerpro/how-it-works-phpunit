<?php

declare(strict_types=1);

namespace Test;

use Test\Event\Failure;
use Test\Event\Pass;
use Throwable;

final class EventEmitter
{
    /**
     * @var EventListener[]
     */
    private array $listeners = [];

    public function addListener(EventListener $listener): void
    {
        $this->listeners[] = $listener;
    }

    public function testsStart(): void
    {
        foreach ($this->listeners as $listener) {
            $listener->onTestsStart();
        }
    }

    public function testPass(TestCase $test): void
    {
        foreach ($this->listeners as $listener) {
            $listener->onPass(new Pass($test));
        }
    }

    public function testIncomplete(TestCase $test, Throwable $error): void
    {
        foreach ($this->listeners as $listener) {
            $listener->onIncomplete(new Failure($test, $error));
        }
    }

    public function testFailure(TestCase $test, Throwable $error): void
    {
        foreach ($this->listeners as $listener) {
            $listener->onFailure(new Failure($test, $error));
        }
    }

    public function testError(TestCase $test, Throwable $error): void
    {
        foreach ($this->listeners as $listener) {
            $listener->onError(new Failure($test, $error));
        }
    }

    public function testsComplete(): void
    {
        foreach ($this->listeners as $listener) {
            $listener->onTestsComplete();
        }
    }
}
