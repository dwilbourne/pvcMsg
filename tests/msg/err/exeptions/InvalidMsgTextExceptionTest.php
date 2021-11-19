<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg\err\exeptions;

use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\msg\err\ExceptionConstants;
use pvc\msg\err\exceptions\InvalidMsgTextException;
use pvc\msg\MsgInterface;

/**
 * Class InvalidMsgTextExceptionTest
 * @covers \pvc\msg\err\exceptions\InvalidMsgTextException
 */
class InvalidMsgTextExceptionTest extends TestCase
{
    /**
     * testInvalidMsgTextException
     */
    public function testInvalidMsgTextException(): void
    {
        $msg = Mockery::mock(MsgInterface::class);
        $previous = Mockery::mock(Exception::class);
        $exception = new InvalidMsgTextException($msg, $previous);
        self::assertEquals($msg, $exception->getMsg());
        self::assertEquals(ExceptionConstants::INVALID_MSGTEXT_EXCEPTION, $exception->getCode());
        self::assertEquals($previous, $exception->getPrevious());
    }
}
