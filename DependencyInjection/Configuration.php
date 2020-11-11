<?php

namespace NaeSymfonyBundles\NaeRestBundle\DependencyInjection;

//use NaeSymfonyBundles\NaeAuthBundle\EventSubscriber\NaeTokenSubscriber;
use NaeSymfonyBundles\NaeRestBundle\Maker\MakeRest;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('nae_rest');

        return $builder;
    }
}
