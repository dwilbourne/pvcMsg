<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use pvc\interfaces\msg\MsgInterface;

/**
 * Class Msg
 */
class Msg implements MsgInterface
{
    /**
     * @var string
     * this is the id that will be used to retrieve the full message from the domain catalog
     */
    protected string $msgId;

    /**
     * @var string
     * the MsgFrmtr will use this to make sure the correct catalog is loaded (or load the correct
     * one) before attempting to retrieve the message text
     */
    protected string $domain;

    /**
     * @var array<mixed>
     * parameters used to fill any placeholders in the message text
     */
    protected array $parameters;

    /**
     * @return string
     */
    public function getMsgId(): string
    {
        return $this->msgId;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return array<mixed>
     */
    public function getParameters(): array
    {
        return $this->parameters ?? [];
    }

    /**
     * @param non-empty-string $domain
     * @param non-empty-string $msgId
     * @param mixed[] $parameters
     */
    public function setContent(string $domain, string $msgId, array $parameters = []): void
    {
        $this->domain = $domain;
        $this->msgId = $msgId;
        $this->parameters = $parameters;
    }

    /**
     * clear
     */
    public function clearContent(): void
    {
        unset($this->domain);
        unset($this->msgId);
        unset($this->parameters);
    }

    /**
     * contentIsSet
     * @return bool
     */
    public function contentIsSet(): bool
    {
        return isset($this->msgId);
    }
}
