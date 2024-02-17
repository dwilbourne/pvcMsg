<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use pvc\interfaces\msg\DomainCatalogLoaderInterface;
use pvc\interfaces\msg\LoaderFactoryInterface;
use pvc\msg\err\MissingLoaderConfigParameterException;
use pvc\msg\err\NonExistentDomainCatalogDirectoryException;
use pvc\msg\err\UnknownLoaderTypeException;

/**
 * Class LoaderFactory
 */
class LoaderFactory implements LoaderFactoryInterface
{
    protected string $projectRoot;

    public function setProjectRoot(string $root): void
    {
        $this->projectRoot = $root;
    }

    public function getProjectRoot(): string
    {
        return $this->projectRoot;
    }

    /**
     * makeLoader
     * @param string $loaderType
     * @param array<string, string[]> $parameters
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
            if (!isset($parameters['dirName'])) {
                throw new MissingLoaderConfigParameterException('dirName');
            } else {
                /** @var string $dirName */
                $dirName = $parameters['dirName'];
            }
            /**
             * The DomainCatalogFileLoader class checks the validity of the directory before setting the value so no
             * need to do that here.
             */
            $catalogDirectory = $this->projectRoot . DIRECTORY_SEPARATOR . $dirName;
            $loader->setDomainCatalogDirectory($catalogDirectory);
        }
        return $loader;
    }
}
