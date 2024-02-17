<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @noinspection PhpCSValidationInspection
 */

declare(strict_types=1);

namespace pvc\msg\err;

use pvc\err\XDataAbstract;

/**
 * Class _MsgXData
 * @noinspection PhpCSValidationInspection
 */
class _MsgXData extends XDataAbstract
{
    public function getLocalXCodes(): array
    {
        return [
            NonExistentDomainCatalogFileException::class => 1001,
            NonExistentDomainCatalogDirectoryException::class => 1002,
            NonExistentMessageException::class => 1003,
            InvalidDomainCatalogFileException::class => 1004,
            MsgContentNotSetException::class => 1005,
            UnknownLoaderTypeException::class => 1006,
            MissingLoaderConfigParameterException::class => 1007,
            InvalidDomainException::class => 1008,
        ];
    }

    public function getXMessageTemplates(): array
    {
        return [
            NonExistentDomainCatalogFileException::class => 'Domain catalog file ${filename} does not exist for locale ${locale} or the default \'en\'.',
            NonExistentDomainCatalogDirectoryException::class => 'Domain catalog directory ${dirname} does not exist or is inaccessible.',
            NonExistentMessageException::class => 'Catalog has no message that corresponds to msg id ${msgId}',
            InvalidDomainCatalogFileException::class => 'Domain catalog file was not parseable into an array<string, string>.',
            MsgContentNotSetException::class => 'Msg id not set',
            UnknownLoaderTypeException::class => 'Error trying to create unknown loaderFactory type ${badLoaderType}',
            MissingLoaderConfigParameterException::class => 'Missing loaderFactory config parameter \'${missingParamName}\'',
            InvalidDomainException::class => 'Error trying to get config for unknown domain ${invalidDomain}',
        ];
    }
}
