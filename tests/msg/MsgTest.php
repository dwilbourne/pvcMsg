<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg;

use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\msg\Msg;
use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class MsgTest
 * @covers \pvc\msg\Msg
 */
class MsgTest extends TestCase
{
    protected Msg $msg;
    protected string $msgId;
    /**
     * @var mixed[]
     */
    protected array $parameters;
    protected TranslatableInterface $param2;
    protected string $domain;

    public function setUp(): void
    {
        $this->msgId = 'foo';
        /** @phpstan-ignore-next-line */
        $this->param2 = Mockery::mock(TranslatableInterface::class);
        $this->parameters = ['date' => new DateTime('2002/12/13'), 'translatable' => $this->param2];
        $this->domain = 'myMessages';
        $this->msg = new Msg($this->msgId, $this->parameters, $this->domain);
    }

    public function testSetGetMsgId(): void
    {
        self::assertEquals($this->msgId, $this->msg->getMsgId());
    }

    public function testSetGetParameters(): void
    {
        self::assertEquals($this->parameters, $this->msg->getParameters());
    }

    public function testSetGetDomain(): void
    {
        self::assertEquals($this->domain, $this->msg->getDomain());
    }

    public function testTrans(): void
    {
        $locale = 'fr_FR';
        $expectedResult = 'some string';

        /* when second parameter is translated, this is what the parameters should look like */
        $resultParameters = ['date' => $this->parameters['date'], 'translatable' => 'bam'];

        $translator = Mockery::mock(TranslatorInterface::class);

        /** @phpstan-ignore-next-line */
        $this->param2->shouldReceive('trans')->with($translator, $locale)->andReturn('bam');

        /** @phpstan-ignore-next-line */
        $translator->shouldReceive('trans')
                   ->with($this->msgId, $resultParameters, $this->domain, $locale)
                   ->andReturn($expectedResult);

        /** @phpstan-ignore-next-line */
        self::assertEquals($expectedResult, $this->msg->trans($translator, $locale));
    }
}
