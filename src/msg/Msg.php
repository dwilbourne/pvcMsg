<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Msg
 * very minor rewrite of the TranslatableMessage class in Symfony ^5.2
 */
class Msg implements MsgInterface
{
    /**
     * @var string
     */
    protected string $msgId;

    /**
     * @var array
     */
    protected array $parameters;

    /**
     * @var string
     */
    protected string $domain;

    /**
     * @return string
     */
    public function getMsgId(): string
    {
        return $this->msgId;
    }

    /**
     * @param string $msgId
     */
    public function setMsgId(string $msgId): void
    {
        $this->msgId = $msgId;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @param string $msgId
     * @param mixed[] $parameters
     * @param string|null $domain
     */
    public function __construct(string $msgId, array $parameters = [], string $domain = null)
    {
        $this->setMsgId($msgId);
        $this->setParameters($parameters);
        $this->setDomain($domain);
    }

    public function trans(TranslatorInterface $translator, string $locale = null): string
    {
        return $translator->trans(
            $this->getMsgId(),
            array_map(
                static function ($parameter) use ($translator, $locale) {
                    return $parameter instanceof TranslatableInterface ? $parameter->trans(
                        $translator,
                        $locale
                    ) : $parameter;
                },
                $this->getParameters()
            ),
            $this->getDomain(),
            $locale
        );
    }
}
