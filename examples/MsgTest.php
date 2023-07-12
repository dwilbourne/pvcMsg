<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcExamples\msg;

use PHPUnit\Framework\TestCase;
use pvc\msg\DomainCatalog;
use pvc\msg\DomainCatalogFileLoaderPHP;
use pvc\msg\err\NonExistentDomainCatalogFileException;
use pvc\msg\Msg;
use pvc\msg\MsgFrmtr;

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
     * @covers       \pvc\msg\MsgFrmtr::format
     */
    public function testFormatting(string $locale, string $expectedResult): void
    {
        $msg = new Msg($this->testMsgId, $this->parameters, $this->domain);
        $loader = new DomainCatalogFileLoaderPHP($this->messagesDir);
        $domainCatalog = new DomainCatalog($loader);
        $domainCatalog->load($this->domain, $locale);
        $frmtr = new MsgFrmtr($domainCatalog);
        self::assertEquals($expectedResult, $frmtr->format($msg));
    }
}
