<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\msg;

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
    public function __construct(array $vars = [], string $msgText = '')
    {
        $this->setMsgVars($vars);
        $this->setMsgText($msgText);
    }

    /**
     * @function addMsgVar
     * @param mixed $var
     */
    public function addMsgVar($var = null) : void
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
     * @function setMsgText.  MsgText should not have any line termination characters in it.  Line termination
     * is a form of formatting and that behavior should be left to a formatter.
     * @param string $msgText
     */
    public function setMsgText(string $msgText): void
    {
        $this->msgText = $msgText;
    }

    public function __toString()
    {
        return vsprintf($this->getMsgText(), $this->getMsgVars());
    }
}
