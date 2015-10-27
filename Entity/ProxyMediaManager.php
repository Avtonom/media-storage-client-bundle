<?php

namespace Avtonom\MediaStorageClientBundle\Entity;

use Avtonom\MediaStorageClientBundle\Exception\MediaStorageClientProxyMediaManagerException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Avtonom\MediaStorageClientBundle\Service\ApiService;
use Buzz\Message\Response;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ProxyMediaManager
 * @package Avtonom\MediaStorageClientBundle\Entity
 *
 * @link    https://github.com/Avtonom
 * @author  Anton U <avtonomspb@gmail.com>
 */
class ProxyMediaManager
{
    protected $className = 'Avtonom\MediaStorageClientBundle\Entity\ProxyMedia';

    /** @var  ApiService */
    protected $apiService;

    public function __construct($apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @return ProxyMediaInterface
     */
    public function create()
    {
        return new $this->className;
    }

    /**
     * @param Response $response
     * @return ProxyMediaInterface
     *
     * @throws NotFoundHttpException
     * @throws MediaStorageClientProxyMediaManagerException
     */
    public function createFromResponse(Response $response)
    {
        if($response && $response->isOk()){
            $content = json_decode($response->getContent(), true);

            if($content && !json_last_error() && is_array($content)){
                $content = new ArrayCollection($content);
            } else {
                throw new MediaStorageClientProxyMediaManagerException('Client not response new value');
            }

        } elseif($response->getStatusCode() == 404) {
            throw new NotFoundHttpException(sprintf('Unable to find the object'));

        } else {
            throw new MediaStorageClientProxyMediaManagerException('Client response code: '.$response->getStatusCode());
        }

        $proxyMedia = $this->create();
        $proxyMedia->setReferenceFull($content->get('reference_full'));
        $proxyMedia->setName($content->get('name'));

        return $proxyMedia;
    }

    /**
     * @param string $path
     *
     * @return ProxyMediaInterface
     *
     * @throws MediaStorageClientProxyMediaManagerException
     * @throws \Avtonom\MediaStorageClientBundle\Exception\MediaStorageClientApiException
     */
    public function find($path)
    {
        if(empty($path)){
            throw new MediaStorageClientProxyMediaManagerException('Path is empty');
        }
        $referenceFull = parse_url($path, PHP_URL_PATH);

        $response = $this->apiService->getMedia($referenceFull);
        $proxyMedia = $this->createFromResponse($response);
        return $proxyMedia;
    }
}