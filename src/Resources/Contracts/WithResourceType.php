<?php

namespace ResourceLayer\Resources\Contracts;

/**
 * @property string $resourceType
 */
interface WithResourceType
{
    /**
     * Get the plural resource name.
     *
     * @return string
     */
    public function getPluralResourceType(): string;

    /**
     * Get the singular resource name.
     *
     * @return string
     */
    public function getSingularResourceType(): string;

    /**
     * Get the resource type.
     *
     * @return string
     */
    public function getResourceType(): string;
}
