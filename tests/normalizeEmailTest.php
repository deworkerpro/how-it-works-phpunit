<?php

declare(strict_types=1);

namespace Test;

use function App\normalizeEmail;

function normalizeEmailTest(): void
{
    assertEquals('mail@app.test', normalizeEmail('mail@app.test'));
    assertEquals('mail@app.test', normalizeEmail('mail+suffix@app.test'));
    assertEquals('mail@app.test', normalizeEmail('mail+dashed-suffix@app.test'));
    assertEquals('mail@app.test', normalizeEmail('mail+double+suffix@app.test'));
    assertEquals('dashed-mail@app.test', normalizeEmail('dashed-mail+suffix@app.test'));
}
