<?php

namespace Avtonom\MediaStorageClientBundle\EventListener;

use Avtonom\MediaStorageClientBundle\Entity\ProxyMediaManager;
use Avtonom\MediaStorageClientBundle\Exception\MediaStorageClientListenerException;
use Avtonom\MediaStorageClientBundle\Service\ApiService;
use Avtonom\MediaStorageClientBundle\Service\MediaStorageClientManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Bridge\Monolog\Logger;

/**
 * @package Avtonom\MediaStorageClientBundle\EventListener
 *
 * @todo validate url - backend
 * @todo recucle http://www.whitewashing.de/2013/07/24/doctrine_and_domainevents.html
 * @todo two file listener and run send
 * @todo move config interfaces to use Trait
 * @todo use wrapper to set/get field
 */
class ChangeFieldListener
{
    /**
     * @var ApiService
     */
    protected $apiService;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var ProxyMediaManager
     */
    protected $proxyMediaManager;

    /**
     * @var MediaStorageClientManager
     */
    protected $mediaStorageClientManager;

    /**
     * @param ApiService $apiService
     * @param array $config
     * @param Logger $logger
     * @param ProxyMediaManager $proxyMediaManager
     * @param MediaStorageClientManager $mediaStorageClientManager
     */
    function __construct(ApiService $apiService, $config, Logger $logger, ProxyMediaManager $proxyMediaManager, MediaStorageClientManager $mediaStorageClientManager)
    {
        $this->apiService = $apiService;
        $this->config = $config;
        $this->logger = $logger;
        $this->proxyMediaManager = $proxyMediaManager;
        $this->mediaStorageClientManager = $mediaStorageClientManager;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     * @throws MediaStorageClientListenerException
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        try{
            $this->run($eventArgs);
        } catch(MediaStorageClientListenerException $e){
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     * @throws MediaStorageClientListenerException
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        try{
            $this->run($eventArgs);
        } catch(MediaStorageClientListenerException $e){
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     * @throws MediaStorageClientListenerException
     */
    protected function run(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        $interfaces = $this->getConfig('interfaces');
        if(empty($interfaces) || !is_array($interfaces)){
            $this->logger->debug('$interfaces: '.print_r($interfaces, true));
            throw new MediaStorageClientListenerException('Config "interfaces" empty or not array');
        }

        $reflection = new \ReflectionClass($entity);
        if (!count( array_intersect($interfaces, $reflection->getInterfaceNames()) )) {
            return;
        }

        $ignoredDomains = $this->getConfig('ignored_domains');
        if(empty($ignoredDomains) || !is_array($ignoredDomains)){
            $this->logger->debug('$ignoredDomains: '.print_r($ignoredDomains, true));
            throw new MediaStorageClientListenerException('Config "ignoredDomains" empty or not array');
        }

        $changeField = $this->getConfig('change_field');
        if($eventArgs instanceof PreUpdateEventArgs){
            if (!$eventArgs->hasChangedField($changeField)) {
                $this->logger->debug('Change not field "value" in entity');
                return;
            }
            $value = $eventArgs->getNewValue($changeField);
        } else {
            $value = $entity->getValue();
        }
        if(empty($value)){
            $this->logger->debug('Empty value in entity');
            return;
        }

        $this->logger->debug('Change value in entity: '.$value);
        if (!$this->checkDomain($value)) {
            $proxyMedia = $this->mediaStorageClientManager->send($value, $this->getConfig('client'), $this->getConfig('context'));
            if(!$this->checkDomain($proxyMedia->getReferenceFull())){
                $this->logger->debug('Response: '.$proxyMedia);
                throw new MediaStorageClientListenerException('Client response new value not found in config "ignoredDomains"');
            }

            $this->logger->debug('Set new value: '.$proxyMedia);
            $entity->setValue($proxyMedia);
        } else {
            $this->logger->debug(sprintf('Value in ignoredDomains "%s" in entity', implode(', ', $ignoredDomains)));
        }
    }

    protected function getConfig($field)
    {
        return (isset($this->config['listener'][$field])) ? $this->config['listener'][$field] : null;
    }

    protected function checkDomain($value)
    {
        $host = parse_url($value, PHP_URL_HOST);
        if(empty($host)){
            $this->logger->warning('Host is empty: '.$value. ' '.print_r(parse_url($value), true));
            throw new MediaStorageClientListenerException('Host is empty: '.$value);
        }
        return (in_array($host, $this->getConfig('ignored_domains')));
    }
}
