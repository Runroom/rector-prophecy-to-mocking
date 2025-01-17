<?php

declare(strict_types=1);

namespace Rector\ProphecyToMocking\Naming;

use Rector\ProphecyToMocking\Enum\PhpSpecMethodName;
use Rector\ProphecyToMocking\Enum\PHPUnitMethodName;

final class SystemMethodDetector
{
    /**
     * @var array<class-string>
     */
    private const METHOD_NAME_CLASSES = [PhpSpecMethodName::class, PHPUnitMethodName::class];

    public static function detect(string $methodName): bool
    {
        foreach (self::METHOD_NAME_CLASSES as $methodNameClass) {
            $reflectionClass = new \ReflectionClass($methodNameClass);

            if (\in_array($methodName, $reflectionClass->getConstants(), true)) {
                return true;
            }
        }

        return false;
    }
}
