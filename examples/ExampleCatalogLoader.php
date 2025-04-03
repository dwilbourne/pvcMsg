<?php

declare (strict_types=1);

namespace pvcExamples\msg;

use pvc\interfaces\msg\DomainCatalogLoaderInterface;
use pvc\msg\DomainCatalogFileLoaderPhp;

class ExampleCatalogLoader extends DomainCatalogFileLoaderPhp implements DomainCatalogLoaderInterface
{
    public function __construct()
    {
        $this->setDomainCatalogDirectory(__DIR__);
    }
}