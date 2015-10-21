<?php

namespace Avtonom\MediaStorageClientBundle\Twig;

use Avtonom\MediaStorageClientBundle\Entity\ProxyMediaInterface;
use Avtonom\MediaStorageClientBundle\Entity\ProxyMediaManager;

class MediaNameExtension extends \Twig_Extension
{
    /** @var ProxyMediaManager */
    protected $proxyMediaManager;

    public function __construct(ProxyMediaManager $proxyMediaManager)
    {
        $this->proxyMediaManager = $proxyMediaManager;
    }

    public function getFunctions()
    {
        return array
        (
            new \Twig_SimpleFunction('media_name', [$this, 'getMediaName'])
        );
    }

    /**
     * @param string $mediaReferenceFull
     * @return ProxyMediaInterface
     */
    private function getMedia($mediaReferenceFull)
    {
        return $media = $this->proxyMediaManager->find($mediaReferenceFull);
    }

    /**
     * @param string $mediaReferenceFull
     * @return string
     */
    public function getMediaName($mediaReferenceFull)
    {
        if(empty($mediaReferenceFull)){
            return '';
        }
        $media = $this->getMedia($mediaReferenceFull);
        return ($media instanceof ProxyMediaInterface) ? $media->getName() : '';
    }

    public function getName()
    {
        return 'AvtonomMediaStorageClientTwigMediaNameExtension';
    }
}
