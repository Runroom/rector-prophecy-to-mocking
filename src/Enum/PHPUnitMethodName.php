<?php

declare(strict_types=1);

namespace Rector\ProphecyToMocking\Enum;

/**
 * @api used in method detection
 */
final class PHPUnitMethodName
{
    /**
     * @var string
     */
    public const ONCE = 'once';

    /**
     * @var string
     */
    public const IS_TYPE = 'isType';

    /**
     * @var string
     */
    public const IS_INSTANCE_OF = 'isInstanceOf';

    /**
     * @var string
     */
    public const EXPECTS = 'expects';

    /**
     * @var string
     */
    public const WITH = 'with';

    /**
     * @var string
     */
    public const METHOD_ = 'method';

    /**
     * @var string
     */
    public const EQUAL_TO = 'equalTo';

    /**
     * @var string
     */
    public const NEVER = 'never';

    /**
     * @var string
     */
    public const CREATE_MOCK = 'createMock';

    /**
     * @var string
     */
    public const ANY = 'any';

    /**
     * @var string
     */
    public const WILL_RETURN = 'willReturn';

    /**
     * @var string
     */
    public const TEAR_DOWN = 'tearDown';

    /**
     * @var string
     */
    public const EXACTLY = 'exactly';

    /**
     * @var string
     */
    public const WILL_RETURN_MAP = 'willReturnMap';

    /**
     * @var string
     */
    public const WILL_THROW_EXCEPTION = 'willThrowException';

    /**
     * @var string
     */
    public const EXPECT_EXCEPTION = 'expectException';

    /**
     * @var string
     */
    public const CALLBACK = 'callback';

    /**
     * @var string
     */
    public const ASSERT_SAME = 'assertSame';

    /**
     * @var string
     */
    public const ASSERT_NOT_SAME = 'assertNotSame';

    /**
     * @var string
     */
    public const AT_LEAST_ONCE = 'atLeastOnce';

    /**
     * @var string
     */
    public const REVEAL = 'reveal';
}
