<?php

declare(strict_types=1);

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

use pvc\interfaces\frmtr\msg\FrmtrMsgInterface;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgInterface;
use pvc\interfaces\msg\MsgTranslatorInterface;

/**
 * Class MsgTranslator
 */
class MsgTranslator implements MsgTranslatorInterface
{
    /**
     * @var DomainCatalogInterface
     */
    protected DomainCatalogInterface $catalog;

    /**
     * @var FrmtrMsgInterface
     */
    protected FrmtrMsgInterface $frmtr;

    /**
     * @return DomainCatalogInterface
     */
    public function getCatalog(): DomainCatalogInterface
    {
        return $this->catalog;
    }

    /**
     * @param DomainCatalogInterface $catalog
     */
    public function setCatalog(DomainCatalogInterface $catalog): void
    {
        $this->catalog = $catalog;
    }

    /**
     * @param FrmtrMsgInterface $frmtr
     */
    public function setFrmtr(FrmtrMsgInterface $frmtr): void
    {
        $this->frmtr = $frmtr;
    }

    /**
     * @return FrmtrMsgInterface
     */
    public function getFrmtr(): FrmtrMsgInterface
    {
        return $this->frmtr;
    }

    /**
     * @param DomainCatalogInterface $catalog
     * @param FrmtrMsgInterface $frmtr
     */
    public function __construct(DomainCatalogInterface $catalog, FrmtrMsgInterface $frmtr)
    {
        $this->setCatalog($catalog);
        $this->setFrmtr($frmtr);
    }

    /**
     * trans
     * @param MsgInterface $msg
     * @return string
     */
    public function trans(MsgInterface $msg): string
    {
        $this->frmtr->setLocale($this->catalog->getLocale());
        $this->frmtr->setFormat($this->catalog->getMessage($msg->getMsgId()));
        return $this->frmtr->format($msg);
    }
}
