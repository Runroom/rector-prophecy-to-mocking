<?php

declare(strict_types=1);

namespace Rector\ProphecyToMocking\NodeFinder;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\NodeFinder;

final class MethodCallFinder
{
    public static function hasByName(Node $node, string $desiredMethodName): bool
    {
        $foundMethodCall = self::findByName($node, $desiredMethodName);

        return $foundMethodCall instanceof MethodCall;
    }

    /**
     * Looks for $this->method('desiredMethod');.
     */
    public static function hasMethodMockByName(Node $node, string $desiredMethodName): bool
    {
        $nodeFinder = new NodeFinder();

        return (bool) $nodeFinder->find($node, function (Node $node) use ($desiredMethodName) {
            if (!$node instanceof MethodCall) {
                return null;
            }

            if ($node->name->toString() !== 'method') {
                return null;
            }

            $firstArg = $node->getArgs()[0];
            if (!$firstArg->value instanceof Node\Scalar\String_) {
                return null;
            }

            $string = $firstArg->value;

            return $string->value === $desiredMethodName;
        });
    }

    public static function findByName(Node $node, string $desiredMethodName): ?Node
    {
        $nodeFinder = new NodeFinder();

        $foundMethodCall = $nodeFinder->findFirst($node, static function (Node $node) use ($desiredMethodName): bool {
            if (!$node instanceof MethodCall) {
                return false;
            }

            if (!$node->name instanceof Identifier) {
                return false;
            }

            return $node->name->toString() === $desiredMethodName;
        });

        /* @var Node|null $foundMethodCall */
        return $foundMethodCall;
    }
}
