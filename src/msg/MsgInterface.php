<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\msg;

/**
 * Interface MsgInterface
 * @package pvc\msg
 */
interface MsgInterface extends MsgRetrievalInterface
{
    /**
     * addMsgVar
     * @param null $var
     */
    public function addMsgVar($var) : void;

    /**
     * setMsgVars
     * @param mixed[] $vars
     */
    public function setMsgVars(array $vars) : void;


    /**
     * setMsgText
     * @param string $msgText
     */
    public function setMsgText(string $msgText): void;
}
