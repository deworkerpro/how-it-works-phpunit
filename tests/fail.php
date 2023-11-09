<?php

declare(strict_types=1);

namespace Test;

function fail(string $reason = 'Fail'): void
{
    throw new AssertException($reason);
}
