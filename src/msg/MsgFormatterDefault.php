<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\msg;


class MsgFormatterDefault implements MsgFormatterInterface
{

    /**
     * @var bool.  Controls whether or not the data is echoed back out as part of the message.
     */
    protected bool $outputMsgVars = false;

    /**
     * outputMsgVars
     * @param bool $value
     */
    public function outputMsgVars(bool $value) : void
    {
        $this->outputMsgVars = $value;
    }

    public function getOutputMsgVarsValue() : bool
    {
        return $this->outputMsgVars;
    }

    /**
     * stripMsgVarsFromMsgText
     * @return string
     */
    protected function stripMsgVarsFromMsgText(string $msgText) : string
    {
        // remove text that starts with a left paren and a % sign and then ends with a right paren.  Strip either
        // the leading whitespace or the trailing whitespace but not both
        $pattern = '/(\s+\(*\%.*\))|(\(%.*\)\s+)/U';
        $result = preg_replace($pattern, '', $msgText);
        // phpstan wants us to check if preg_replace returns null, in which case we return the original string
        return $result ?: $msgText;
    }

    protected function tidyWhitespace(string $msgText) : string
    {
        // replace excess whitespace, removing tabs, form feeds etc at the same time.
        $pattern = '/\s+/';
        $result = preg_replace($pattern, ' ', $msgText);
        // phpstan wants us to check if preg_replace returns null, in which case we return the original string
        return $result ?: $msgText;
    }

    public function format(MsgRetrievalInterface $msg): string
    {
        $msgText = $msg->getMsgText();
        $msgText = $this->outputMsgVars ? $msgText : $this->stripMsgVarsFromMsgText($msgText);
        $msgText = $this->tidyWhitespace($msgText);
        return vsprintf($msgText, $msg->getMsgVars());
    }
}