<?php

namespace Avtonom\MediaStorageClientBundle\Twig;

use Avtonom\MediaStorageClientBundle\Entity\ProxyMediaInterface;

class InstanceOfExtension extends \Twig_Extension
{
    public function getTests ()
    {
        return [
            new \Twig_SimpleTest('proxyMedia', function ($event) { return $event instanceof ProxyMediaInterface; }),
        ];
    }

    public function getName()
    {
        return 'AvtonomMediaStorageClientTwigInstanceOfExtension';
    }
}
