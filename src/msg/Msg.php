<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

use pvc\msg\err\exceptions\InvalidMsgTextException;
use pvc\msg\err\messages\InvalidMsgTextMsg;

/**
 * Class Msg
 */
class Msg implements MsgInterface
{
    /**
     * @var string[]
     */
    protected array $msgVars = [];

    /**
     * @var string
     */
    protected string $msgText;

    /**
     * Msg constructor.
     * @param string[] $vars
     * @param string $msgText
     */
    public function __construct(array $vars, string $msgText)
    {
        $this->setMsgVars($vars);
        $this->setMsgText($msgText);
    }

    /**
     * @function addMsgVar
     * @param string $var
     */
    public function addMsgVar(string $var): void
    {
        if (empty($var)) {
            $var = '{{ null or empty string }}';
        }
        $this->msgVars[] = $var;
    }

    /**
     * @function getMsgVars
     * @return string[]
     */
    public function getMsgVars(): array
    {
        return $this->msgVars;
    }

    /**
     * @function setMsgVars
     * @param mixed[] $vars
     */
    public function setMsgVars(array $vars): void
    {
        $this->msgVars = [];
        foreach ($vars as $var) {
            $this->addMsgVar($var);
        }
    }

    /**
     * @function getMsgText
     * @return string
     */
    public function getMsgText(): string
    {
        return $this->msgText;
    }

    /**
     * @function setMsgText.
     * @param string $msgText
     */
    public function setMsgText(string $msgText): void
    {
        if (empty($msgText)) {
            $msg = new InvalidMsgTextMsg();
            throw new InvalidMsgTextException($msg);
        }
        $this->msgText = $msgText;
    }
}
