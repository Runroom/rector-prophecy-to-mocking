<?php

namespace Rector\ProphecyToMocking\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class ProphesizeRule extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Replace Prophecy usage with PHPUnit MockObject', [
            new CodeSample(
                <<<'CODE_SAMPLE'
protected function setUp(): void
{
    $this->someProphecy = $this->prophesize(SomeClass::class);
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
protected function setUp(): void
{
    $this->someMock = $this->createMock(SomeClass::class);
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
        // Handle `prophesize` to `createMock` replacement
        if (($node instanceof MethodCall) && $node->name instanceof Node\Identifier
            && $this->isName($node->name, 'prophesize')
        ) {
            $node->name = new Node\Identifier('createMock');

            return $node;
        }

        return null;
    }
}
