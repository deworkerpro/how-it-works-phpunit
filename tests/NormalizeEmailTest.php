<?php

declare(strict_types=1);

namespace Test;

use InvalidArgumentException;
use Test\Attribute\DataProvider;

use function App\normalizeEmail;

final class NormalizeEmailTest extends TestCase
{
    #[DataProvider('getValues')]
    public function testCorrect(string $expected, string $email): void
    {
        self::assertEquals($expected, normalizeEmail($email));
    }

    public static function getValues(): iterable
    {
        return [
            'simple' => ['mail@app.test', 'mail@app.test'],
            'suffix' => ['mail@app.test', 'mail+suffix@app.test'],
            'dashed-suffix' => ['mail@app.test', 'mail+dashed-suffix@app.test'],
            'double+suffix' => ['mail@app.test', 'mail+double+suffix@app.test'],
            'dashed-mail' => ['dashed-mail@app.test', 'dashed-mail+suffix@app.test'],
        ];
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);

        normalizeEmail('not-email');
    }

    public function testIncomplete(): void
    {
        self::markTestIncomplete('I am too lazy...');
    }
}
