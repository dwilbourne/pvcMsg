<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\msg;


interface MsgFormatterInterface
{
    public function format(MsgRetrievalInterface $msg) : string;

    public function outputMsgVars(bool $value) : void;

}