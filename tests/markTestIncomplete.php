<?php

declare(strict_types=1);

namespace Test;

function markTestIncomplete(string $reason = ''): void
{
    throw new IncompleteTestException($reason);
}
