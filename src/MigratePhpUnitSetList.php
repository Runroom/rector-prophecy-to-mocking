<?php

namespace Rector\ProphecyToMocking;

use Rector\Set\Contract\SetListInterface;

class MigratePhpUnitSetList implements SetListInterface
{
    public const PHPUNIT = __DIR__ . '/config/prophecy-to-phpunit.php';
}