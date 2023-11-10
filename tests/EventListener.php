<?php

declare(strict_types=1);

namespace Test;

use Test\Event\Failure;
use Test\Event\Pass;

interface EventListener
{
    public function onPass(Pass $event): void;
    public function onIncomplete(Failure $event): void;
    public function onFailure(Failure $event): void;
    public function onError(Failure $event): void;
}
