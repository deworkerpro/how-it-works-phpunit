<?php

declare(strict_types=1);

namespace Test;

use Throwable;

final readonly class TestFailure
{
    public function __construct(
        public TestCase $test,
        public Throwable $error
    ) {}
}
