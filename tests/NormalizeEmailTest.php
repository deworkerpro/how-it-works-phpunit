<?php

declare(strict_types=1);

namespace Test;

use InvalidArgumentException;

use function App\normalizeEmail;

final class NormalizeEmailTest extends TestCase
{
    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);

        normalizeEmail('not-email');
    }

    public function testSimple(): void
    {
        assertEquals('mail@app.test', normalizeEmail('mail@app.test'));
    }

    public function testSuffix(): void
    {
        assertEquals('mail@app.test', normalizeEmail('mail+suffix@app.test'));
    }

    public function testDashedSuffix(): void
    {
        markTestIncomplete('I am too lazy...');

        assertEquals('mail@app.test', normalizeEmail('mail+dashed-suffix@app.test'));
    }

    public function testDoubleSuffix(): void
    {
        assertEquals('mail@app.test', normalizeEmail('mail+double+suffix@app.test'));
    }

    public function testDashedMail(): void
    {
        assertEquals('dashed-mail@app.test', normalizeEmail('dashed-mail+suffix@app.test'));
    }
}
