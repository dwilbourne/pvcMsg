<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use MessageFormatter;
use pvc\interfaces\frmtr\msg\FrmtrMsgInterface;
use pvc\interfaces\intl\LocaleInterface;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgInterface;
use pvc\msg\err\MsgContentNotSetException;
use pvc\msg\err\NonExistentMessageException;

/**
 * Class MsgFrmtr
 *
 * this class does not extend Frmtr because Frmtr lives in a different library.  So in order to keep dependencies to
 * a minimum, the class takes care of its own Locale awareness.
 */
class MsgFrmtr implements FrmtrMsgInterface
{
    /**
     * @var LocaleInterface
     */
    protected LocaleInterface $locale;

    /**
     * @var DomainCatalogInterface
     */
    protected DomainCatalogInterface $domainCatalog;

    /**
     * @param DomainCatalogInterface $domainCatalog
     * @param LocaleInterface $locale
     */
    public function __construct(DomainCatalogInterface $domainCatalog, LocaleInterface $locale)
    {
        $this->domainCatalog = $domainCatalog;
        $this->setLocale($locale);
    }

    /**
     * getDomainCatalog
     * @return DomainCatalogInterface
     */
    public function getDomainCatalog(): DomainCatalogInterface
    {
        return $this->domainCatalog;
    }

    /**
     * setDomainCatalog
     * @param DomainCatalogInterface $domainCatalog
     */
    public function setDomainCatalog(DomainCatalogInterface $domainCatalog): void
    {
        $this->domainCatalog = $domainCatalog;
    }

    /**
     * getLocale
     * @return LocaleInterface
     */
    public function getLocale(): LocaleInterface
    {
        return $this->locale;
    }

    /**
     * setLocale
     * @param LocaleInterface $locale
     */
    public function setLocale(LocaleInterface $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * format
     *
     * @param MsgInterface $value
     * @return string
     * @throws MsgContentNotSetException
     * @throws NonExistentMessageException
     */
    public function format($value): string
    {
        if (!$value->contentIsSet()) {
            throw new MsgContentNotSetException();
        }
        /** @var string $domain */
        $domain = $value->getDomain();

        /** @var string $msgId */
        $msgId = $value->getMsgId();

        /** @var array<string> $parameters */
        $parameters = $value->getParameters();

        $this->getDomainCatalog()->load($domain, (string)$this->getLocale());
        $pattern = $this->getDomainCatalog()->getMessage($msgId);

        if (!$pattern) {
            throw new NonExistentMessageException($msgId);
        }

        $frmtr = MessageFormatter::create((string)$this->getLocale(), $pattern);

        /**
         * if \MessageFormatter fails for some reason, return an empty string
         */
        return ($frmtr->format($parameters) ?: '');
    }
}
