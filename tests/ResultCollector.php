<?php

declare(strict_types=1);

namespace Test;

use Test\Event\Failure;
use Test\Event\Pass;

final class ResultCollector implements EventListener
{
    private array $pass = [];
    private array $incomplete = [];
    private array $failure = [];
    private array $error = [];

    public function onTestsStart(): void
    {
    }

    public function onPass(Pass $event): void
    {
        $this->pass[] = $event;
    }

    public function onIncomplete(Failure $event): void
    {
        $this->incomplete[] = $event;
    }

    public function onFailure(Failure $event): void
    {
        $this->failure[] = $event;
    }

    public function onError(Failure $event): void
    {
        $this->error[] = $event;
    }

    public function onTestsComplete(): void
    {
    }

    public function getResult(): TestResult
    {
        return new TestResult(
            pass: $this->pass,
            incomplete: $this->incomplete,
            failure: $this->failure,
            error: $this->error
        );
    }
}
