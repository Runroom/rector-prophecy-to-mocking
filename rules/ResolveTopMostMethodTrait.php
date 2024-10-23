<?php

namespace Rector\ProphecyToMocking;

use PhpParser\Node\Expr\MethodCall;

trait ResolveTopMostMethodTrait
{
    private function resolveTopMostMethodCall(MethodCall $methodCall): MethodCall
    {
        $nestedMethodCall = $methodCall;
        while ($nestedMethodCall->var instanceof MethodCall) {
            $nestedMethodCall = $nestedMethodCall->var;
        }

        return $nestedMethodCall;
    }
}
