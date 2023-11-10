<?php

declare(strict_types=1);

namespace Test\Event;

use Test\TestCase;
use Throwable;

final readonly class Failure
{
    public function __construct(
        public TestCase $test,
        public Throwable $error,
    ) {}
}
