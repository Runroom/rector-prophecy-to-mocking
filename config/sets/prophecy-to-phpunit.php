<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Removing\Rector\Class_\RemoveTraitUseRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\ProphecyToMocking\Rector\Expression\MethodRule;
use Rector\ProphecyToMocking\Rector\Expression\ShouldBeCalledRule;
use Rector\ProphecyToMocking\Rector\MethodCall\ProphesizeRule;
use Rector\ProphecyToMocking\Rector\MethodCall\RemoveShouldBeCalled;
use Rector\ProphecyToMocking\Rector\MethodCall\RevealRule;
use Rector\ProphecyToMocking\Rector\StaticCall\ReplaceArgumentTypeWithIsInstanceOf;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RemoveTraitUseRector::class, [
        'Prophecy\PhpUnit\ProphecyTrait',
    ]);
    $rectorConfig->ruleWithConfiguration(RenameClassRector::class, [
        'Prophecy\Prophecy\ObjectProphecy' => 'PHPUnit\Framework\MockObject\MockObject',
    ]);
    $rectorConfig->rules([
        ProphesizeRule::class,
        MethodRule::class,
        ShouldBeCalledRule::class,
        RemoveShouldBeCalled::class,
        RevealRule::class,
        ReplaceArgumentTypeWithIsInstanceOf::class,
    ]);
};
