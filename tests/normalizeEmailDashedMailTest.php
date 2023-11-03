<?php

declare(strict_types=1);

namespace Test;

use function App\normalizeEmail;

function normalizeEmailDashedMailTest(): void
{
    assertEquals('dashed-mail@app.test', normalizeEmail('dashed-mail+suffix@app.test'));
}
