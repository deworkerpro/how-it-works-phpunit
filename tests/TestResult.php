<?php

declare(strict_types=1);

namespace Test;

final readonly class TestResult
{
    public function __construct(
        private int $passCount,
        private int $incompleteCount,
        private int $failureCount,
        private int $errorCount
    ) {}

    public function isSuccess(): bool
    {
        return $this->failureCount === 0 && $this->errorCount === 0;
    }

    public function getPassCount(): int
    {
        return $this->passCount;
    }

    public function getIncompleteCount(): int
    {
        return $this->incompleteCount;
    }

    public function getFailureCount(): int
    {
        return $this->failureCount;
    }

    public function getErrorCount(): int
    {
        return $this->errorCount;
    }
}
