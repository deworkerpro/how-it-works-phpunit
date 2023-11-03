<?php

declare(strict_types=1);

function normalizeEmail(string $email): string {
    return $email;
}

echo 'Email: ' . normalizeEmail('mail+suffix@app.test') . PHP_EOL;
