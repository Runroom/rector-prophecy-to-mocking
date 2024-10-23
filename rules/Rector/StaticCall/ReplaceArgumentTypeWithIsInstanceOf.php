<?php

namespace Rector\ProphecyToMocking\Rector\StaticCall;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use Rector\Rector\AbstractRector;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class ReplaceArgumentTypeWithIsInstanceOf extends AbstractRector
{
    public function __construct(private StaticTypeMapper $staticTypeMapper)
    {

    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Replace Prophecy usage with PHPUnit MockObject', [
            new CodeSample(
                <<<'CODE_SAMPLE'
Argument::type(Classname::class)
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
$this->isInstanceOf(Classname::class)
CODE_SAMPLE
            ),
        ]);
    }

    public function getNodeTypes(): array
    {
        return [StaticCall::class];
    }

    public function refactor(Node $node): ?Node
    {
        // Check if the method is `type` and the class is `Argument`
        if (!$this->isName($node->name, 'type')) {
            return null;
        }

        // Resolve the class calling the static method using StaticTypeMapper
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($node->class);

        if ($staticType->getClassName() !== 'Prophecy\Argument') {
            return null;
        }

        // Change the method call to $this->isInstanceOf()
        return $this->nodeFactory->createLocalMethodCall(
            'isInstanceOf',
            $node->args
        );
    }
}
