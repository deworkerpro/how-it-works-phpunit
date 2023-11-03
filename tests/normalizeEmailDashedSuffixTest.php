<?php

declare(strict_types=1);

namespace Test;

use function App\normalizeEmail;

function normalizeEmailDashedSuffixTest(): void
{
    assertEquals('mail@app.test', normalizeEmail('mail+dashed-suffix@app.test'));
}
