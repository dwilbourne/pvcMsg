<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\msg;

use Exception;

/**
 * parent class / default implementation for message creation
 *
 * Pvc distinguishes between user messages (see @UserMsg) and error / exception messages
 * (see @ErrorExceptionMsg).  Both of these classes inherit this implementation.
 *
 * Class Msg
 */

class Msg implements MsgInterface
{
    use MsgVarsOutputTrait;
    use MsgInterchangeabilityTrait;

    /**
     * @var mixed[]
     */
    protected array $msgVars = [];

    /**
     * @var string
     */
    protected string $msgText;


    /**
     * Msg constructor.
     * @param mixed[] $vars
     * @param string $msgText
     */
    public function __construct(array $vars, string $msgText)
    {
        $this->setMsgVars($vars);
        $this->setMsgText($msgText);
    }

    /**
     * @function addMsgVar
     * @param mixed $var
     */
    public function addMsgVar($var) : void
    {
        if (empty($var)) {
            $var = '{{ null or empty string }}';
        }
        $this->msgVars[] = $var;
    }

    /**
     * @function countMsgVars
     * @return int
     */
    public function countMsgVars(): int
    {
        return count($this->msgVars);
    }

    /**
     * @function getMsgVars
     * @return mixed[]
     */
    public function getMsgVars(): array
    {
        return $this->msgVars;
    }

    /**
     * @function setMsgVars
     * @param mixed[] $vars
     */
    public function setMsgVars(array $vars) : void
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
            throw new Exception();
        }
        $this->msgText = $msgText;
    }

}
