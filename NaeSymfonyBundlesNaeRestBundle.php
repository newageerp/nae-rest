<?php

namespace NaeSymfonyBundles\NaeRestBundle;

use NaeSymfonyBundles\NaeRestBundle\DependencyInjection\NaeRestExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class NaeSymfonyBundlesNaeRestBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new NaeRestExtension();
    }
}
