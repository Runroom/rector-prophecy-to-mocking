<?php

namespace Rector\ProphecyToMocking\Rector\Expression;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeTraverser;
use Rector\ProphecyToMocking\Naming\MethodProphecyDetector;
use Rector\Rector\AbstractRector;
use Rector\ProphecyToMocking\Enum\PhpSpecMethodName;
use Rector\ProphecyToMocking\Enum\PHPUnitMethodName;
use Rector\ProphecyToMocking\Naming\SystemMethodDetector;
use Rector\ProphecyToMocking\NodeFactory\ExpectsCallFactory;
use Rector\ProphecyToMocking\NodeFinder\MethodCallFinder;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class MethodRule extends AbstractRector
{
    public function getNodeTypes(): array
    {
        return [Expression::class];
    }

    public function refactor(Node $node): ?Node
    {
        // usually long chunk of method call
        if (!$node->expr instanceof MethodCall) {
            return null;
        }

        $firstMethodCall = $node->expr;

        // usually a chain method call
        if (!$firstMethodCall->var instanceof MethodCall) {
            return null;
        }

        $hasChanged = false;

        // handled in another rule
        $hasShouldNotBeCalled = MethodCallFinder::hasByName($node, PhpSpecMethodName::SHOULD_NOT_BE_CALLED);

        $this->traverseNodesWithCallable($firstMethodCall, function (Node $node) use (
            &$hasChanged

        ): null|int|MethodCall {
            if (!$node instanceof MethodCall) {
                return null;
            }

            // handled in another rule
            if ($this->isName($node->name, PHPUnitMethodName::REVEAL)) {
                return null;
            }

            // special case for nested callable
            if ($this->isName($node->name, PHPUnitMethodName::CALLBACK)) {
                return NodeTraverser::STOP_TRAVERSAL;
            }

            // rename method
            if ($this->isName($node->name, PhpSpecMethodName::WILL_THROW)) {
                $node->name = new Identifier(PHPUnitMethodName::WILL_THROW_EXCEPTION);

                return $node;
            }

            // typically the top method call must be on a variable
            if (!$node->var instanceof Variable && !$node->var instanceof PropertyFetch) {
                return null;
            }

            // already converted
            if (SystemMethodDetector::detect($node->name->toString())) {
                return null;
            }

            // It the method is not from the prophecy library, we don't need to convert it
            if (!MethodProphecyDetector::detect($node->name->toString())) {
                return null;
            }

            $hasChanged = true;

            /** @var string $methodName */
            $methodName = $this->getName($node->name);

            $methodMethodCall = ExpectsCallFactory::createMethodCall($node->var, $methodName);

            $callArgs = $node->getArgs();
            if ($callArgs !== []) {
                return $this->appendWithMethodCall($methodMethodCall, $callArgs);
            }

            return $methodMethodCall;
        });

        if (!$hasChanged) {
            return null;
        }

        return $node;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('From PhpSpec mock expectations to PHPUnit mock expectations', [
            new CodeSample(
                <<<'CODE_SAMPLE'
use PhpSpec\ObjectBehavior;

class ResultSpec extends ObjectBehavior
{
    public function it_returns()
    {
        $this->run()->willReturn(1000);
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
use PhpSpec\ObjectBehavior;

class ResultSpec extends ObjectBehavior
{
    public function it_returns()
    {
        $this->method('run')->willReturn(1000);
    }
}
CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @param Arg[] $args
     */
    private function appendWithMethodCall(MethodCall $methodCall, array $args): MethodCall
    {
        foreach ($args as $arg) {
            if ($arg->value instanceof StaticCall) {
                $staticCall = $arg->value;

                /** @var string $className */
                $className = $this->getName($staticCall->class);

                if (str_ends_with($className, 'Argument')) {
                    if ($this->isName($staticCall->name, 'any')) {
                        // no added value having this method
                        return $methodCall;
                    }

                    if ($this->isName($staticCall->name, 'that')) {
                        // will return callable
                        $expr = $staticCall->getArgs()[0]
                            ->value;

                        return new MethodCall($methodCall, PHPUnitMethodName::WILL_RETURN, [new Arg($expr)]);
                    }
                }
            }
        }

        return new MethodCall($methodCall, PHPUnitMethodName::WITH, $args);
    }
}
