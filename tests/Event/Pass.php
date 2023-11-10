<?php

declare(strict_types=1);

namespace Test\Event;

use Test\TestCase;

final readonly class Pass
{
    public function __construct(
        public TestCase $test
    ) {}
}
