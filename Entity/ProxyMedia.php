<?php

namespace Avtonom\MediaStorageClientBundle\Entity;

/**
 * Class ProxyMedia
 * @package Avtonom\MediaStorageClientBundle\Entity
 *
 * @link    https://github.com/Avtonom
 * @author  Anton U <avtonomspb@gmail.com>
 */
class ProxyMedia implements ProxyMediaInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string
     */
    protected $originUrl;

    /**
     * @var string
     */
    protected $referenceFull;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var string
     */
    protected $providerName;

    /**
     * @var int
     */
    protected $providerStatus;

    /**
     * @var string
     */
    protected $providerReference;

    /**
     * @var array
     */
    protected $providerMetadata = array();

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var int
     */
    protected $length;

    /**
     * @var string
     */
    protected $copyright;

    /**
     * @var string
     */
    protected $authorName;

    /**
     * @var string
     */
    protected $context;

    protected $cdnIsFlushable;

    /**
     * @var \Datetime
     */
    protected $cdnFlushAt;

    /**
     * @var int
     */
    protected $cdnStatus;

    /**
     * @var \Datetime
     */
    protected $updatedAt;

    /**
     * @var \Datetime
     */
    protected $createdAt;

    protected $binaryContent;

    protected $previousProviderReference;

    /**
     * @var string
     */
    protected $contentType;

    /**
     * @var int
     */
    protected $size;

    public function __toString()
    {
        return $this->getReferenceFull(); // Use the link that is namely it is the object identifier. It is used in logging, and adding the value of the entity
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'url' => $this->getReferenceFull(),
        ];
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function setId($id)
    {
        return $this->id = $id;
    }

    /**
     * @return string
     */
    public function getOriginUrl()
    {
        return $this->originUrl;
    }

    /**
     * @param string $originUrl
     */
    public function setOriginUrl($originUrl)
    {
        $this->originUrl = $originUrl;
    }

    /**
     * @return string
     *
     */
    public function getReferenceFull()
    {
        return $this->referenceFull;
    }

    /**
     * @param string $referenceFull
     */
    public function setReferenceFull($referenceFull)
    {
        $this->referenceFull = $referenceFull;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Set enabled.
     *
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled.
     *
     * @return bool $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * @param string $providerName
     */
    public function setProviderName($providerName)
    {
        $this->providerName = $providerName;
    }

    /**
     * @return int
     */
    public function getProviderStatus()
    {
        return $this->providerStatus;
    }

    /**
     * @param int $providerStatus
     */
    public function setProviderStatus($providerStatus)
    {
        $this->providerStatus = $providerStatus;
    }

    /**
     * @return string
     */
    public function getProviderReference()
    {
        return $this->providerReference;
    }

    /**
     * @param string $providerReference
     */
    public function setProviderReference($providerReference)
    {
        $this->providerReference = $providerReference;
    }

    /**
     * @return array
     */
    public function getProviderMetadata()
    {
        return $this->providerMetadata;
    }

    /**
     * Set provider_metadata.
     *
     * @param array $providerMetadata
     */
    public function setProviderMetadata(array $providerMetadata = array())
    {
        $this->providerMetadata = $providerMetadata;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return decimal
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param decimal $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @param string $copyright
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param string $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param string $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return mixed
     */
    public function getCdnIsFlushable()
    {
        return $this->cdnIsFlushable;
    }

    /**
     * @param mixed $cdnIsFlushable
     */
    public function setCdnIsFlushable($cdnIsFlushable)
    {
        $this->cdnIsFlushable = $cdnIsFlushable;
    }

    /**
     * @return mixed
     */
    public function getCdnFlushAt()
    {
        return $this->cdnFlushAt;
    }

    /**
     * Set cdn_flush_at.
     *
     * @param \Datetime $cdnFlushAt
     */
    public function setCdnFlushAt(\Datetime $cdnFlushAt = null)
    {
        $this->cdnFlushAt = $cdnFlushAt;
    }

    /**
     * @return int
     */
    public function getCdnStatus()
    {
        return $this->cdnStatus;
    }

    /**
     * @param int $cdnStatus
     */
    public function setCdnStatus($cdnStatus)
    {
        $this->cdnStatus = $cdnStatus;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updated_at.
     *
     * @param \Datetime $updatedAt
     */
    public function setUpdatedAt(\Datetime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set created_at.
     *
     * @param \Datetime $createdAt
     */
    public function setCreatedAt(\Datetime $createdAt = null)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getBinaryContent()
    {
        return $this->binaryContent;
    }

    /**
     * @param mixed $binaryContent
     */
    public function setBinaryContent($binaryContent)
    {
        $this->binaryContent = $binaryContent;
    }

    /**
     * @return mixed
     */
    public function getPreviousProviderReference()
    {
        return $this->previousProviderReference;
    }

    /**
     * @param mixed $previousProviderReference
     */
    public function setPreviousProviderReference($previousProviderReference)
    {
        $this->previousProviderReference = $previousProviderReference;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadataValue($name, $default = null)
    {
        $metadata = $this->getProviderMetadata();

        return isset($metadata[$name]) ? $metadata[$name] : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetadataValue($name, $value)
    {
        $metadata = $this->getProviderMetadata();
        $metadata[$name] = $value;
        $this->setProviderMetadata($metadata);
    }

    /**
     * {@inheritdoc}
     */
    public function unsetMetadataValue($name)
    {
        $metadata = $this->getProviderMetadata();
        unset($metadata[$name]);
        $this->setProviderMetadata($metadata);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension()
    {
        return pathinfo($this->getProviderReference(), PATHINFO_EXTENSION);
    }
}