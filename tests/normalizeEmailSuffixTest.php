<?php

declare(strict_types=1);

namespace Test;

use function App\normalizeEmail;

function normalizeEmailSuffixTest(): void
{
    assertEquals('mail@app.test', normalizeEmail('mail+suffix@app.test'));
}
