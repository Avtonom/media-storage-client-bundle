<?php

namespace Avtonom\MediaStorageClientBundle\Entity;

interface ProxyMediaInterface
{
    const STATUS_OK          = 1;
    const STATUS_SENDING     = 2;
    const STATUS_PENDING     = 3;
    const STATUS_ERROR       = 4;
    const STATUS_ENCODING    = 5;

    /**
     * @return string
     */
    function __toString();

    /**
     * @return array
     */
    function toArray();

    /**
     * @param mixed $binaryContent
     */
    function setBinaryContent($binaryContent);

    /**
     * @return mixed
     */
    function getBinaryContent();

    /**
     * @param string $name
     * @param null   $default
     */
    function getMetadataValue($name, $default = null);

    /**
     * @param string $name
     * @param mixed  $value
     */
    function setMetadataValue($name, $value);

    /**
     * Remove a named data from the metadata.
     *
     * @param string $name
     */
    function unsetMetadataValue($name);

    /**
     * @return mixed
     */
    function getId();

    /**
     * @param integer $id
     *
     * @return mixed
     */
    function setId($id);

    /**
     * Set name.
     *
     * @param string $name
     */
    function setName($name);

    /**
     * Get name.
     *
     * @return string $name
     */
    function getName();

    /**
     * @return string
     */
    function getOriginUrl();

    /**
     * @param string $originUrl
     */
    function setOriginUrl($originUrl);

    /**
     * @return string
     */
    function getReferenceFull();

    /**
     * @param string $referenceFull
     */
    function setReferenceFull($referenceFull);

    /**
     * Set description.
     *
     * @param string $description
     */
    function setDescription($description);

    /**
     * Get description.
     *
     * @return string $description
     */
    function getDescription();

    /**
     * Set enabled.
     *
     * @param bool $enabled
     */
    function setEnabled($enabled);

    /**
     * Get enabled.
     *
     * @return bool $enabled
     */
    function getEnabled();

    /**
     * Set provider_name.
     *
     * @param string $providerName
     */
    function setProviderName($providerName);

    /**
     * Get provider_name.
     *
     * @return string $providerName
     */
    function getProviderName();

    /**
     * Set provider_status.
     *
     * @param int $providerStatus
     */
    function setProviderStatus($providerStatus);

    /**
     * Get provider_status.
     *
     * @return int $providerStatus
     */
    function getProviderStatus();

    /**
     * Set provider_reference.
     *
     * @param string $providerReference
     */
    function setProviderReference($providerReference);

    /**
     * Get provider_reference.
     *
     * @return string $providerReference
     */
    function getProviderReference();

    /**
     * Set provider_metadata.
     *
     * @param array $providerMetadata
     */
    function setProviderMetadata(array $providerMetadata = array());

    /**
     * Get provider_metadata.
     *
     * @return array $providerMetadata
     */
    function getProviderMetadata();

    /**
     * Set width.
     *
     * @param int $width
     */
    function setWidth($width);

    /**
     * Get width.
     *
     * @return int $width
     */
    function getWidth();

    /**
     * Set height.
     *
     * @param int $height
     */
    function setHeight($height);

    /**
     * Get height.
     *
     * @return int $height
     */
    function getHeight();

    /**
     * Set length.
     *
     * @param float $length
     */
    function setLength($length);

    /**
     * Get length.
     *
     * @return float $length
     */
    function getLength();

    /**
     * Set copyright.
     *
     * @param string $copyright
     */
    function setCopyright($copyright);

    /**
     * Get copyright.
     *
     * @return string $copyright
     */
    function getCopyright();

    /**
     * Set authorName.
     *
     * @param string $authorName
     */
    function setAuthorName($authorName);

    /**
     * Get authorName.
     *
     * @return string $authorName
     */
    function getAuthorName();

    /**
     * Set context.
     *
     * @param string $context
     */
    function setContext($context);

    /**
     * Get context.
     *
     * @return string $context
     */
    function getContext();

    /**
     * Set cdnIsFlushable.
     *
     * @param bool $cdnIsFlushable
     */
    function setCdnIsFlushable($cdnIsFlushable);

    /**
     * Get cdn_is_flushable.
     *
     * @return bool $cdnIsFlushable
     */
    function getCdnIsFlushable();

    /**
     * Set cdn_flush_at.
     *
     * @param \Datetime $cdnFlushAt
     */
    function setCdnFlushAt(\Datetime $cdnFlushAt = null);

    /**
     * Get cdn_flush_at.
     *
     * @return \Datetime $cdnFlushAt
     */
    function getCdnFlushAt();

    /**
     * Set updated_at.
     *
     * @param \Datetime $updatedAt
     */
    function setUpdatedAt(\Datetime $updatedAt = null);

    /**
     * Get updated_at.
     *
     * @return \Datetime $updatedAt
     */
    function getUpdatedAt();

    /**
     * Set created_at.
     *
     * @param \Datetime $createdAt
     */
    function setCreatedAt(\Datetime $createdAt = null);

    /**
     * Get created_at.
     *
     * @return \Datetime $createdAt
     */
    function getCreatedAt();

    /**
     * Set content_type.
     *
     * @param string $contentType
     */
    function setContentType($contentType);

    /**
     * @return string
     */
    function getExtension();

    /**
     * Get content_type.
     *
     * @return string $contentType
     */
    function getContentType();

    /**
     * Set size.
     *
     * @param int $size
     */
    function setSize($size);

    /**
     * Get size.
     *
     * @return int $size
     */
    function getSize();

    /**
     * Set cdn_status.
     *
     * @param int $cdnStatus
     */
    function setCdnStatus($cdnStatus);

    /**
     * Get cdn_status.
     *
     * @return int $cdnStatus
     */
    function getCdnStatus();

    /**
     * @return string
     */
    function getPreviousProviderReference();
}