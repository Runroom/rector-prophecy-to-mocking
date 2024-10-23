<?php

namespace Rector\ProphecyToMocking\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class RevealRule extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Replace Prophecy usage with PHPUnit MockObject', [
            new CodeSample(
                <<<'CODE_SAMPLE'
protected function testSomething(): void
{
    $this->someProphecy->reveal();
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
protected function testSomething(): void
{
    $this->someProphecy;
}
CODE_SAMPLE
            ),
        ]);
    }

    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    public function refactor(Node $node): ?Node
    {
        // Remove `reveal` method if exists
        if (($node instanceof MethodCall) && $node->name instanceof Node\Identifier
            && $this->isName($node->name, 'reveal')
        ) {
            return $node->var;
        }

        return null;
    }
}
