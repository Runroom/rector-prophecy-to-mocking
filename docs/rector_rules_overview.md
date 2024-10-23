# 6 Rules Overview

## MethodRule

From PhpSpec mock expectations to PHPUnit mock expectations

- class: [`Rector\ProphecyToMocking\Rector\Expression\MethodRule`](../rules/Rector/Expression/MethodRule.php)

```diff
 use PhpSpec\ObjectBehavior;

 class ResultSpec extends ObjectBehavior
 {
     public function it_returns()
     {
-        $this->run()->willReturn(1000);
+        $this->method('run')->willReturn(1000);
     }
 }
```

<br>

## ProphesizeRule

Replace Prophecy usage with PHPUnit MockObject

- class: [`Rector\ProphecyToMocking\Rector\MethodCall\ProphesizeRule`](../rules/Rector/MethodCall/ProphesizeRule.php)

```diff
 protected function setUp(): void
 {
-    $this->someProphecy = $this->prophesize(SomeClass::class);
+    $this->someMock = $this->createMock(SomeClass::class);
 }
```

<br>

## RemoveShouldBeCalled

Remove `shouldBeCalled()` as implicit in PHPUnit, also empty `willReturn()` as no return is implicit in PHPUnit

- class: [`Rector\ProphecyToMocking\Rector\MethodCall\RemoveShouldBeCalled`](../rules/Rector/MethodCall/RemoveShouldBeCalled.php)

```diff
 use PhpSpec\ObjectBehavior;

 class ResultSpec extends ObjectBehavior
 {
     public function it_is_initializable()
     {
-        $this->run()->shouldBeCalled();
+        $this->run();

-        $this->go()->willReturn();
+        $this->go();
     }
 }
```

<br>

## ReplaceArgumentTypeWithIsInstanceOf

Replace Prophecy usage with PHPUnit MockObject

- class: [`Rector\ProphecyToMocking\Rector\StaticCall\ReplaceArgumentTypeWithIsInstanceOf`](../rules/Rector/StaticCall/ReplaceArgumentTypeWithIsInstanceOf.php)

```diff
-Argument::type(Classname::class)
+$this->isInstanceOf(Classname::class)
```

<br>

## RevealRule

Replace Prophecy usage with PHPUnit MockObject

- class: [`Rector\ProphecyToMocking\Rector\MethodCall\RevealRule`](../rules/Rector/MethodCall/RevealRule.php)

```diff
 protected function testSomething(): void
 {
-    $this->someProphecy->reveal();
+    $this->someProphecy;
 }
```

<br>

## ShouldBeCalledRule

Replace Prophecy usage with PHPUnit MockObject

- class: [`Rector\ProphecyToMocking\Rector\Expression\ShouldBeCalledRule`](../rules/Rector/Expression/ShouldBeCalledRule.php)

```diff
 protected function setUp(): void
 {
-    $this->someProphecy->someMethod()->shouldBeCalled();
+    $this->someMock->expects($this->once())->method('someMethod');
 }
```

<br>
