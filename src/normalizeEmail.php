<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

function normalizeEmail(string $email): string
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('Incorrect Email format.');
    }

    return preg_replace('/\+[^@]+@/', '@', $email);
}
