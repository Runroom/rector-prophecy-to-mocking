<?php

namespace Rector\ProphecyToMocking\Enum;

class ProphecyMethodName
{
    public const WITH_ARGUMENTS = 'withArguments';

    public const WILL = 'will';

    public const WILL_RETURN = 'willReturn';

    public const WILL_YIELD = 'willYield';

    public const WILL_RETURN_ARGUMENT = 'willReturnArgument';

    public const WILL_THROW = 'willThrow';

    public const SHOULD = 'should';

    public const SHOULD_BE_CALLED = 'shouldBeCalled';

    public const SHOULD_NOT_BE_CALLED = 'shouldNotBeCalled';

    public const SHOULD_BE_CALLED_TIMES = 'shouldBeCalledTimes';

    public const SHOULD_BE_CALLED_ONCE = 'shouldBeCalledOnce';

    public const SHOULD_HAVE = 'shouldHave';

    public const SHOULD_HAVE_BEEN_CALLED = 'shouldHaveBeenCalled';

    public const SHOULD_NOT_HAVE_BEEN_CALLED = 'shouldNotHaveBeenCalled';

    public const SHOULD_NOT_BEEN_CALLED = 'shouldNotBeenCalled';

    public const SHOULD_HAVE_BEEN_CALLED_TIMES = 'shouldHaveBeenCalledTimes';

    public const SHOULD_HAVE_BEEN_CALLED_ONCE = 'shouldHaveBeenCalledOnce';

    public const CHECK_PREDICTION = 'checkPrediction';

    public const GET_PROMISE = 'getPromise';

    public const GET_PREDICTION = 'getPrediction';

    public const GET_CHECKED_PREDICTIONS = 'getCheckedPredictions';

    public const GET_OBJECT_PROPHECY = 'getObjectProphecy';

    public const GET_METHOD_NAME = 'getMethodName';

    public const GET_ARGUMENTS_WILDCARD = 'getArgumentsWildcard';

    public const HAS_RETURN_VOID = 'hasReturnVoid';

    public const BIND_TO_OBJECT_PROPHECY = 'bindToObjectProphecy';
}
