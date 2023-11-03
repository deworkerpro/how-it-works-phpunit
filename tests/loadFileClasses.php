<?php

declare(strict_types=1);

namespace Test;

/**
 * @return string[]
 */
function loadFileClasses(string $file): array
{
    $beforeClassesCount = count(get_declared_classes());
    require $file;

    return array_slice(get_declared_classes(), $beforeClassesCount);
}
