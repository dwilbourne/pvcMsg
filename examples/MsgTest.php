<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcExamples\msg;

use PHPUnit\Framework\TestCase;
use pvc\frmtr\msg\MsgFrmtr;
use pvc\intl\Locale;
use pvc\msg\DomainCatalog;
use pvc\msg\err\NonExistentDomainCatalogFileException;
use pvc\msg\Msg;

class MsgTest extends TestCase
{
    /**
     * @var string
     */
    protected string $messagesDir;

    /**
     * @var string
     */
    protected string $domain;

    /**
     * @var string
     */
    protected string $testMsgId;

    /**
     * @var array<string, string>
     */
    protected array $parameters;

    public function setUp(): void
    {
        $this->messagesDir = __DIR__;
        $this->domain = 'messages';
        $this->testMsgId = 'invitation_title';
        $this->parameters = ['organizer_gender' => 'female', 'organizer_name' => 'Jane'];
    }

    /**
     * getMsgData
     * @return array<array<string>>
     */
    public function getMsgData(): array
    {
        return [
            ['en', 'Jane has invited you to her party!'],
            ['fr', 'Jane vous a invite a sa fete!'],
        ];
    }

    /**
     * testFormatting
     * @throws NonExistentDomainCatalogFileException
     * @dataProvider getMsgData
     * @covers       \pvc\frmtr\msg\MsgFrmtr::format
     */
    public function testFormatting(string $localeString, string $expectedResult): void
    {
        $msg = new Msg();
        $msg->setContent($this->domain, $this->testMsgId, $this->parameters);

        $loader = new ExampleCatalogLoader();
        $domainCatalog = new DomainCatalog($loader);
        $domainCatalog->load($this->domain, $localeString);

        $locale = new Locale();
        $locale->setLocaleString($localeString);
        $frmtr = new MsgFrmtr($domainCatalog, $locale);
        self::assertEquals($expectedResult, $frmtr->format($msg));
    }
}
