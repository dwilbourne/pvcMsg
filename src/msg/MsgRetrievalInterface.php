<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\msg;

/**
 * Class MsgRetrievalInterface
 * @package pvc\msg
 */
interface MsgRetrievalInterface
{
    /**
     * getMsgVars
     * @return mixed[]
     */
    public function getMsgVars() : array;

    /**
     * getMsgText
     * @return string
     */
    public function getMsgText(): string;

    /**
     * makeUserMsg
     * @return UserMsg
     */
    public function makeUserMsg(): UserMsg;

    /**
     * makeErrorExceptionMsg
     * @return ErrorExceptionMsg
     */
    public function makeErrorExceptionMsg(): ErrorExceptionMsg;
}
