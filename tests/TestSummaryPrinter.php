<?php

declare(strict_types=1);

namespace Test;

final readonly class TestSummaryPrinter
{
    public function print(TestResult $result): void
    {
        if ($result->isSuccess()) {
            echo "\033[30;42m OK \033[0m" . PHP_EOL;
        } else {
            echo "\033[30;41m FAIL \033[0m" . PHP_EOL;
        }

        echo sprintf(
                "\033[30;43m Pass: %d, Incomplete: %d, Failure: %d, Error: %d \033[0m",
                $result->getPassCount(),
                $result->getIncompleteCount(),
                $result->getFailureCount(),
                $result->getErrorCount(),
            ) . PHP_EOL;
    }
}
