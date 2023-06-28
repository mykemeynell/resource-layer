<?php

namespace ResourceLayer\Resources\Concerns;

use Illuminate\Support\Str;

trait HasResourceType
{
    /**
     * @inheritDoc
     */
    public function getPluralResourceType(): string
    {
        return Str::plural($this->getResourceType());
    }

    /**
     * @inheritDoc
     */
    public function getSingularResourceType(): string
    {
        return Str::singular($this->getResourceType());
    }

    /**
     * @inheritDoc
     */
    public function getResourceType(): string
    {
        if(property_exists($this, 'resourceType')) {
            return $this->resourceType;
        }

        $className = Str::afterLast(static::class, '\\');
        return Str::slug(Str::beforeLast($className,
            config('resource-layer.resource_suffix', 'Resource')
        ));
    }
}
