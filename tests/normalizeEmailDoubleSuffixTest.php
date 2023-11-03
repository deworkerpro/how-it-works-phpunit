<?php

declare(strict_types=1);

namespace Test;

use function App\normalizeEmail;

function normalizeEmailDoubleSuffixTest(): void
{
    assertEquals('mail@app.test', normalizeEmail('mail+double+suffix@app.test'));
}
