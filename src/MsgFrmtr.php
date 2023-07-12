<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use MessageFormatter;
use pvc\interfaces\frmtr\msg\FrmtrMsgInterface;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgInterface;

/**
 * Class MsgTranslator
 */
class MsgFrmtr implements FrmtrMsgInterface
{
    /**
     * @var DomainCatalogInterface
     */
    protected DomainCatalogInterface $catalog;

    /**
     * @return DomainCatalogInterface
     */
    public function getDomainCatalog(): DomainCatalogInterface
    {
        return $this->catalog;
    }

    /**
     * @param DomainCatalogInterface $catalog
     */
    public function setDomainCatalog(DomainCatalogInterface $catalog): void
    {
        $this->catalog = $catalog;
    }

    /**
     * @param DomainCatalogInterface $catalog
     */
    public function __construct(DomainCatalogInterface $catalog)
    {
        $this->setDomainCatalog($catalog);
    }

    /**
     * format
     * @param MsgInterface $msg
     * @return string
     * if it fails, it returns an empty string
     */
    public function format(MsgInterface $msg): string
    {
        $pattern = $this->catalog->getMessage($msg->getMsgId());
        $locale = $this->catalog->getLocale();
        $frmtr = MessageFormatter::create($locale, $pattern);
        return ($frmtr->format($msg->getParameters()) ?: '');
    }
}
