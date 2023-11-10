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
        self::assertEquals('mail@app.test', normalizeEmail('mail@app.test'));
    }

    public function testSuffix(): void
    {
        self::assertEquals('mail@app.test', normalizeEmail('mail+suffix@app.test'));
    }

    public function testDashedSuffix(): void
    {
        self::markTestIncomplete('I am too lazy...');

        self::assertEquals('mail@app.test', normalizeEmail('mail+dashed-suffix@app.test'));
    }

    public function testDoubleSuffix(): void
    {
        self::assertEquals('mail@app.test', normalizeEmail('mail+double+suffix@app.test'));
    }

    public function testDashedMail(): void
    {
        self::assertEquals('dashed-mail@app.test', normalizeEmail('dashed-mail+suffix@app.test'));
    }
}
