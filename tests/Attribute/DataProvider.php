<?php

declare(strict_types=1);

namespace Test\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final readonly class DataProvider
{
    public function __construct(
        public string $methodName
    ) {}
}
