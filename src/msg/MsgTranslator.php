<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

use MessageFormatter;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgTranslatorInterface;

/**
 * Class MsgTranslator
 */
class MsgTranslator implements MsgTranslatorInterface
{
    protected DomainCatalogInterface $catalog;

    public function __construct(DomainCatalogInterface $catalog)
    {
        $this->setCatalog($catalog);
    }

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
     * trans
     * @param string $msgId
     * @param mixed[] $parameters
     * @return string
     */
    public function trans(string $msgId, array $parameters) : string
    {
        $locale = $this->catalog->getLocale();
        $pattern = $this->catalog->getMessage($msgId);
        $icuFormatter = MessageFormatter::create($locale, $pattern);
        $result = $icuFormatter->format($parameters);
        // return the msgId is the format method encounters an error and returns false
        return (false != $result) ? $result : $msgId;
    }
}
