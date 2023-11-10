<?php

declare(strict_types=1);

namespace Test;

use Test\Event\Failure;
use Test\Event\Pass;

final readonly class TestProgressPrinter implements EventListener
{
    public function onTestsStart(): void
    {
        echo "Running tests" . PHP_EOL . PHP_EOL;
    }

    public function onPass(Pass $event): void
    {
        echo "\033[1;0m.\033[0m";
    }

    public function onIncomplete(Failure $event): void
    {
        echo "\033[1;33mI\033[0m";
    }

    public function onFailure(Failure $event): void
    {
        echo "\033[30;41mF\033[0m";
    }

    public function onError(Failure $event): void
    {
        echo "\033[30;41mE\033[0m";
    }

    public function onTestsComplete(): void
    {
        echo PHP_EOL . PHP_EOL;
    }
}
