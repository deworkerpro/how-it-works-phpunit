<?php

declare(strict_types=1);

namespace Test;

use InvalidArgumentException;
use Throwable;

use function App\normalizeEmail;

final class NormalizeEmailTest
{
    public static function testIncorrect(): void
    {
        try {
            normalizeEmail('not-email');
            fail('Incorrect email is passed');
        } catch (AssertException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            if (!$exception instanceof InvalidArgumentException) {
                fail('Incorrect exception type ' . $exception::class);
            }
        }
    }

    public static function testSimple(): void
    {
        assertEquals('mail@app.test', normalizeEmail('mail@app.test'));
    }

    public static function testSuffix(): void
    {
        assertEquals('mail@app.test', normalizeEmail('mail+suffix@app.test'));
    }

    public static function testDashedSuffix(): void
    {
        markTestIncomplete('I am too lazy...');

        assertEquals('mail@app.test', normalizeEmail('mail+dashed-suffix@app.test'));
    }

    public static function testDoubleSuffix(): void
    {
        assertEquals('mail@app.test', normalizeEmail('mail+double+suffix@app.test'));
    }

    public static function testDashedMail(): void
    {
        assertEquals('dashed-mail@app.test', normalizeEmail('dashed-mail+suffix@app.test'));
    }
}
