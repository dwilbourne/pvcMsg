<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use pvc\interfaces\msg\DomainCatalogLoaderInterface;
use pvc\msg\err\MissingLoaderConfigParameterException;
use pvc\msg\err\NonExistentDomainCatalogDirectoryException;
use pvc\msg\err\UnknownLoaderTypeException;

/**
 * Class LoaderFactory
 */
class LoaderFactory
{
    /**
     * makeLoader
     * @param string $loaderType
     * @param array<string, string> $parameters
     * @return DomainCatalogLoaderInterface
     * @throws MissingLoaderConfigParameterException
     * @throws NonExistentDomainCatalogDirectoryException
     * @throws UnknownLoaderTypeException
     */
    public function makeLoader(string $loaderType, array $parameters): DomainCatalogLoaderInterface
    {
        switch ($loaderType) {
            case 'php':
                $loader = new DomainCatalogFileLoaderPHP();
                break;
            default:
                throw new UnknownLoaderTypeException($loaderType);
        }

        if ($loader instanceof DomainCatalogFileLoader) {
            $dirName = 'dirName';
            if (!isset($parameters[$dirName])) {
                throw new MissingLoaderConfigParameterException($dirName);
            }
            $loader->setDomainCatalogDirectory($parameters[$dirName]);
        }
        return $loader;
    }
}
