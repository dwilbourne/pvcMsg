<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg\err;

use pvc\err\XDataTestMaster;
use pvc\msg\err\_MsgXData;

/**
 * Class _MsgXDataTest
 */
class _MsgXDataTest extends XDataTestMaster
{
    /**
     * testLibrary
     * @covers \pvc\msg\err\_MsgXData::getLocalXCodes
     * @covers \pvc\msg\err\_MsgXData::getXMessageTemplates
     * @covers \pvc\msg\err\InvalidDomainCatalogFileException::__construct
     * @covers \pvc\msg\err\NonExistentDomainCatalogDirectoryException::__construct
     * @covers \pvc\msg\err\NonExistentDomainCatalogFileException::__construct
     * @covers \pvc\msg\err\NonExistentMessageException::__construct
     * @covers \pvc\msg\err\MsgIdNotSetException::__construct
     */
    public function testLibrary(): void
    {
        $xData = new _MsgXData();
        self::assertTrue($this->verifyLibrary($xData));
    }
}
