<?php

declare(strict_types=1);

namespace Test;

abstract class TestCase
{
    private ?string $expectedException = null;

    protected function expectException(string $class): void
    {
        $this->expectedException = $class;
    }

    public function getExpectedException(): ?string
    {
        return $this->expectedException;
    }
}
