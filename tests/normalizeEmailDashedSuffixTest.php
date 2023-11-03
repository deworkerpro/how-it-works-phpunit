<?php

declare(strict_types=1);

namespace Test;

use function App\normalizeEmail;

function normalizeEmailDashedSuffixTest(): void
{
    markTestIncomplete('I am too lazy...');

    assertEquals('mail@app.test', normalizeEmail('mail+dashed-suffix@app.test'));
}
