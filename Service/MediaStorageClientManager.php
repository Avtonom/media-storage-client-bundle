<?php

namespace Avtonom\MediaStorageClientBundle\Service;

use Avtonom\MediaStorageClientBundle\Entity\ProxyMediaManager;
use Avtonom\MediaStorageClientBundle\Exception\MediaStorageClientApiException;
use Avtonom\MediaStorageClientBundle\Exception\MediaStorageClientManagerException;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaStorageClientManager
 * @package Avtonom\MediaStorageClientBundle\Service
 *
 * @link    https://github.com/Avtonom
 * @author  Anton U <avtonomspb@gmail.com>
 */
class MediaStorageClientManager
{
    /**
     * @var ProxyMediaManager
     */
    protected $proxyMediaManager;
    /**
     * @var ApiService
     */
    protected $apiService;

    /**
     * @var Logger
     */
    protected $logger;

    function __construct(ApiService $apiService, ProxyMediaManager $proxyMediaManager, Logger $logger)
    {
        $this->apiService = $apiService;
        $this->proxyMediaManager = $proxyMediaManager;
        $this->logger = $logger;
    }

    /**
     * @param string $value
     * @param string $clientName
     * @param string $context
     *
     * @return \Avtonom\MediaStorageClientBundle\Entity\ProxyMediaInterface
     *
     * @throws MediaStorageClientManagerException
     * @throws \Avtonom\MediaStorageClientBundle\Exception\MediaStorageClientProxyMediaManagerException
     */
    public function send($value, $clientName, $context)
    {
        try {
            $response = $this->apiService->send($value, $clientName, $context);
        } catch(MediaStorageClientApiException $e){
            $this->logger->error($e->getMessage());
            throw new MediaStorageClientManagerException($e->getMessage());
        }

        if($response && $response->isOk()){
            $content = json_decode($response->getContent(), true);

            if($content && !json_last_error() && is_array($content)){
                $proxyMedia = $this->proxyMediaManager->createFromResponse($response);
                return $proxyMedia;
            }
            $this->logger->warning('Client not response new value: '.$content);
            throw new MediaStorageClientManagerException('Client not response new value');
        }
        $this->logger->warning('Client response code: '.$response->getStatusCode().' '.$response->getContent());
        throw new MediaStorageClientManagerException('Client response code: '.$response->getStatusCode());
    }

    /**
     * @param UploadedFile $file
     * @param string $clientName
     * @param string $context
     *
     * @return \Avtonom\MediaStorageClientBundle\Entity\ProxyMediaInterface
     *
     * @throws MediaStorageClientManagerException
     * @throws \Avtonom\MediaStorageClientBundle\Exception\MediaStorageClientProxyMediaManagerException
     */
    public function sendFile(UploadedFile $file, $clientName, $context)
    {
        try {
            $response = $this->apiService->sendFile($file, $clientName, $context);
        } catch(MediaStorageClientApiException $e){
            $this->logger->error($e->getMessage());
            throw new MediaStorageClientManagerException($e->getMessage());
        }

        if($response && $response->isOk()){
            $content = json_decode($response->getContent(), true);

            if($content && !json_last_error() && is_array($content) && array_key_exists('reference_full', $content)){
                $proxyMedia = $this->proxyMediaManager->createFromResponse($response);
                return $proxyMedia;
            }
            $this->logger->warning('Client not response new value: '.$content);
            throw new MediaStorageClientManagerException('Client not response new value');
        }
        $this->logger->warning('Client response code: '.$response->getStatusCode().' '.$response->getContent());
        throw new MediaStorageClientManagerException('Client response code: '.$response->getStatusCode());
    }
}
