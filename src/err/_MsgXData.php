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
            InvalidDomainCatalogFileException::class => 1004,
        ];
    }

    public function getXMessageTemplates(): array
    {
        return [
            NonExistentDomainCatalogFileException::class => 'Domain catalog file ${filename} does not exist for locale ${locale} or the default \'en\'.',
            NonExistentDomainCatalogDirectoryException::class => 'Domain catalog directory ${dirname} does not exist or is inaccessible.',
            InvalidDomainCatalogFileException::class => 'Domain catalog file was not parseable into an array<string, string>.',
        ];
    }
}
