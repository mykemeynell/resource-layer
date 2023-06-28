<?php

namespace ResourceLayer\Resources\Concerns;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait HasNavigation
{
    /**
     * Flag for whether the resource can be processed in navigation.
     *
     * @return bool
     */
    public function showInNavigation(): bool
    {
        if(!property_exists($this, 'showInNavigation')) {
            return true;
        }

        return (bool)$this->showInNavigation;
    }

    /**
     * Get the value of the $navigationIcon property.
     *
     * @return null|string
     */
    public function getNavigationIcon(): ?string
    {
        return $this->navigationIcon ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getNavigationGroup(): ?string
    {
        return $this->navigationGroup ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getNavigationDisplayName(): string
    {
        if(property_exists($this, 'navigationDisplayName')) {
            return $this->navigationDisplayName;
        }

        $className = class_basename(static::class);
        $suffix = config('resource-layer.resource_suffix', 'Resource');

        return Str::plural(Str::beforeLast($className, $suffix));
    }
}
