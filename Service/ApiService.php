<?php

namespace Avtonom\MediaStorageClientBundle\Service;

use Avtonom\MediaStorageClientBundle\Exception\MediaStorageClientApiException;
use Buzz\Browser;
use Buzz\Message\Form\FormRequest;
use Buzz\Message\Form\FormUpload;
use Symfony\Bridge\Monolog\Logger;
use Buzz\Message\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ApiService
 * @package Avtonom\MediaStorageClientBundle\Service
 *
 * @link    https://github.com/Avtonom
 * @author  Anton U <avtonomspb@gmail.com>
 */
class ApiService
{
    /**
     * @var Browser
     */
    protected $client;

    protected $config;

    /**
     * @var Logger
     */
    protected $logger;

    function __construct($client, Logger $logger, $config)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * @param string $value
     * @param string $clientName
     * @param string $context
     *
     * @return Response
     *
     * @throws MediaStorageClientApiException
     */
    public function send($value, $clientName, $context)
    {
        try {
            $request = new FormRequest();
            $request->setHeaders(['headers' => 'enctype:multipart/form-data']);
            $request->setMethod($this->getClientsConfig($clientName, 'method') ? $this->getClientsConfig($clientName, 'method') : FormRequest::METHOD_POST);
            $request->setHost($this->getClientsConfig($clientName, 'base_url'));
            $request->addFields([
                'binaryContent' => $value,
                'context' => $context,
            ]);
            $request->setResource($this->getClientsConfig($clientName, 'add_media_url'));
            $this->logger->debug('Send '.$this->getClientsConfig($clientName, 'base_url').$this->getClientsConfig($clientName, 'add_media_url'));
            /** @var Response $response */
            $response = $this->client->send($request, null);
            $this->logger->debug('Response: '.$response->getStatusCode().' '.substr($response->getContent(), 0, 300));

        } catch(\Exception $e) {
            throw new MediaStorageClientApiException($e->getMessage());
        }
        return $response;
    }

    /**
     * @param UploadedFile $file
     * @param string $clientName
     * @param string $context
     *
     * @return Response
     *
     * @throws MediaStorageClientApiException
     *
     * @todo config to $context
     */
    public function sendFile(UploadedFile $file, $clientName, $context)
    {
        try {
            $request = new FormRequest();
            $request->setHeaders(['headers' => 'enctype:multipart/form-data']);
            $request->setMethod($this->getClientsConfig($clientName, 'method') ? $this->getClientsConfig($clientName, 'method') : FormRequest::METHOD_POST);
            $request->setHost($this->getClientsConfig($clientName, 'base_url'));
            $formUpload = new FormUpload($file->getRealPath());
            $formUpload->setFilename($file->getClientOriginalName());
            $request->addFields([
                'binaryContent' => $formUpload,
                'context' => $context,
            ]);
            $request->setResource($this->getClientsConfig($clientName, 'add_media_url'));
            $this->logger->debug('Send '.$this->getClientsConfig($clientName, 'base_url').$this->getClientsConfig($clientName, 'add_media_url'));//.' '.$request->getContent()
            /** @var Response $response */
            $response = $this->client->send($request, null);
            $this->logger->debug('Response: '.$response->getStatusCode().' '.substr($response->getContent(), 0, 300));

        } catch(\Exception $e) {
            throw new MediaStorageClientApiException($e->getMessage());
        }
        return $response;
    }

    /**
     * @param $referenceFull
     *
     * @return Response
     *
     * @throws MediaStorageClientApiException
     */
    public function getMedia($referenceFull)
    {
        if(empty($referenceFull)){
            throw new MediaStorageClientApiException('Param referenceFull is empty');
        }
        try {
            $request = new FormRequest();
            $request->setMethod(FormRequest::METHOD_GET);
            $request->setHost($this->getApiUrlConfig('base_url'));
            $url = $this->getApiUrlConfig('get_media_by_reference_full_url').'/'.ltrim($referenceFull, '/');
            $request->setResource($url);
            $this->logger->debug('Send '.$this->getApiUrlConfig('base_url').$url);
            /** @var Response $response */
            $response = $this->client->send($request, null);
            $this->logger->debug('Response: '.$response->getStatusCode().' '.substr($response->getContent(), 0, 300));

        } catch(\Exception $e) {
            throw new MediaStorageClientApiException($e->getMessage());
        }
        return $response;
    }

    protected function getClientsConfig($name, $field)
    {
        return (isset($this->config['clients'][$name][$field])) ? $this->config['clients'][$name][$field] : null;
    }
    
    protected function getApiUrlConfig($field)
    {
        return (isset($this->config['urls'][$field])) ? $this->config['urls'][$field] : null;
    }
}