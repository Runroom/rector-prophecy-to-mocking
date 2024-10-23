<?php

namespace Rector\ProphecyToMocking\Rector\Expression;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Expression;
use Rector\Rector\AbstractRector;
use Rector\ProphecyToMocking\ResolveTopMostMethodTrait;
use Rector\ProphecyToMocking\NodeFinder\MethodCallFinder;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class ShouldBeCalledRule extends AbstractRector
{
    use ResolveTopMostMethodTrait;

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Replace Prophecy usage with PHPUnit MockObject', [
            new CodeSample(
                <<<'CODE_SAMPLE'
protected function setUp(): void
{
    $this->someProphecy->someMethod()->shouldBeCalled();
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
protected function setUp(): void
{
    $this->someMock->expects($this->once())->method('someMethod');
}
CODE_SAMPLE
            ),
        ]);
    }

    public function getNodeTypes(): array
    {
        return [Expression::class];
    }

    public function refactor(Node $node): ?Node
    {
        if (!$node->expr instanceof MethodCall) {
            return null;
        }

        if (!MethodCallFinder::hasByName($node, 'shouldBeCalled')) {
            return null;
        }

        $topMostMethodCall = $this->resolveTopMostMethodCall($node->expr);

        $onceMethodCall = $this->nodeFactory->createLocalMethodCall('once');
        $args = [new Arg($onceMethodCall)];

        $topMostMethodCall->var = new MethodCall($topMostMethodCall->var, 'expects', $args);

        return $node;
    }
}
