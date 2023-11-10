<?php

declare(strict_types=1);

namespace Test;

abstract class Assert
{
    public static function assertEquals(string $expected, string $actual): void
    {
        if ($actual !== $expected) {
            throw new AssertException(sprintf('Actual value "%s" is not equal to "%s"', $actual, $expected));
        }
    }

    public static function fail(string $reason = 'Fail'): void
    {
        throw new AssertException($reason);
    }
}
