<?php

declare(strict_types=1);

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

use MessageFormatter;
use pvc\interfaces\frmtr\msg\FrmtrMsgInterface;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgInterface;

/**
 * Class MsgTranslator
 */
class FrmtrMsg implements FrmtrMsgInterface
{
    /**
     * @var DomainCatalogInterface
     */
    protected DomainCatalogInterface $catalog;

	/**
	 * @var MessageFormatter
	 */
	protected MessageFormatter $messageFormatter;

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
	 * @param MessageFormatter $messageFormatter
	 */
	public function setMessageFormatter(MessageFormatter $messageFormatter): void
	{
		$this->messageFormatter = $messageFormatter;
	}

	/**
	 * @return MessageFormatter
	 */
	public function getMessageFormatter(): MessageFormatter
	{
		return $this->messageFormatter;
	}

    /**
     * @param DomainCatalogInterface $catalog
     * @param FrmtrMsgInterface $frmtr
     */
    public function __construct(DomainCatalogInterface $catalog, MessageFormatter $frmtr)
    {
        $this->setDomainCatalog($catalog);
		$this->setMessageFormatter($frmtr);
    }

    public function format(MsgInterface $msg): string
    {
		$pattern = $this->catalog->getMessage($msg->getMsgId());
		$locale = $this->catalog->getLocale();
        $frmtr = MessageFormatter::create($locale, $pattern);
        return $frmtr->format($msg->getParameters());
    }
}
