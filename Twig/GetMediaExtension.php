<?php

namespace Avtonom\MediaStorageClientBundle\Twig;

use Avtonom\MediaStorageClientBundle\Entity\ProxyMediaInterface;
use Avtonom\MediaStorageClientBundle\Entity\ProxyMediaManager;

class GetMediaExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('media_get', [$this, 'getMedia'])
        );
    }

    /**
     * @param string $mediaReferenceFull
     *
     * @return ProxyMediaInterface
     */
    public function getMedia($mediaReferenceFull)
    {
        if(empty($mediaReferenceFull)){
            return '';
        }
        try {
            $media = $media = $this->proxyMediaManager->find($mediaReferenceFull);
        } catch(\Exception $e){
            return null;
        }
        return $media;
    }

    public function getName()
    {
        return 'AvtonomMediaStorageClientTwigGetMediaExtension';
    }
}
