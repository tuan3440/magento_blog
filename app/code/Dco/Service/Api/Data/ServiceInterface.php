<?php

namespace Dco\Service\Api\Data;

interface ServiceInterface
{
    /**
     * Constants used as data array keys
     */
    const SERVICE_ID           = 'service_id';
    const NAME              = 'name';
    const CONTENT      = 'content';
    const SHORT_DESCRIPTION = 'short_description';
    const IMAGE             = 'image';
    const IS_ACTIVE           = 'is_active';
    const POSTITION         = 'position';
    const UPDATED_AT        = 'updated_at';
    const CREATED_AT        = 'created_at';

    /**
     * Get id
     *
     * @return int|null
     */
    public function getServiceId();

    /**
     * Set id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setServiceId($id);

    /**
     * Get id
     *
     * @return int|null
     */
    public function getPosition();

    /**
     * Set id
     *
     * @param int $position
     *
     * @return $this
     */
    public function setPosition($position);

    /**
     * Get Name
     *
     * @return string/null
     */
    public function getName();

    /**
     * Set Name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * Get short description
     *
     * @return string/null
     */
    public function getShortDescription();

    /**
     * Set short description
     *
     * @param string $shortDesc
     *
     * @return $this
     */
    public function setShortDescription($shortDesc);

    /**
     * Get Content
     *
     * @return string/null
     */
    public function getContent();

    /**
     * Set Content
     *
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content);

    /**
     * Get Image
     *
     * @return string/null
     */
    public function getImage();

    /**
     * Set Image
     *
     * @param string $content
     *
     * @return $this
     */
    public function setImage($content);

    /**
     * Get Enabled
     *
     * @return int/null
     */
    public function getIsActive();

    /**
     * Set Enabled
     *
     * @param int $enabled
     *
     * @return $this
     */
    public function setIsActive($enabled);

    /**
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated date
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated date
     *
     * @param string $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
