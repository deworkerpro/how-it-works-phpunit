<?php

declare(strict_types=1);

namespace Test;

use function App\normalizeEmail;

function normalizeEmailSimpleTest(): void
{
    assertEquals('mail@app.test', normalizeEmail('mail@app.test'));
}
