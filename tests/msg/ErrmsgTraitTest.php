<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg;

use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\msg\ErrmsgTrait;
use pvc\msg\MsgInterface;

/**
 * Class ErrmsgTraitTest
 * @covers pvc\msg\ErrmsgTrait
 */
class ErrmsgTraitTest extends TestCase
{
    public function testSetGetUnsetErrmsg(): void
    {
        $msg = Mockery::mock(MsgInterface::class);
        $trait = $this->getMockForTrait(ErrmsgTrait::class);
        $trait->setErrmsg($msg);
        self::assertEquals($msg, $trait->getErrmsg());
        $trait->unsetErrmsg();
        self::assertNull($trait->getErrmsg());
    }
}
