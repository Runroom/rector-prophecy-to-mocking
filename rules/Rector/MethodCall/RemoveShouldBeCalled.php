<?php

namespace Rector\ProphecyToMocking\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class RemoveShouldBeCalled extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove shouldBeCalled() as implicit in PHPUnit, also empty willReturn() as no return is implicit in PHPUnit',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use PhpSpec\ObjectBehavior;

class ResultSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->run()->shouldBeCalled();

        $this->go()->willReturn();
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use PhpSpec\ObjectBehavior;

class ResultSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->run();

        $this->go();
    }
}
CODE_SAMPLE
                ),

            ]
        );
    }

    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    public function refactor(Node $node): ?Node
    {
        if ($this->isName($node->name, 'shouldBeCalled')) {
            // The shouldBeCalled() is implicit and not needed, handled by another rule
            return $node->var;
        }

        if ($this->isName($node->name, 'shouldNotBeCalled')) {
            // The shouldNotBeCalled() is implicit and not needed, handled by another rule
            return $node->var;
        }

        if ($this->isName($node->name, 'willReturn') && $node->getArgs() === []) {
            return $node->var;
        }

        return null;
    }
}
