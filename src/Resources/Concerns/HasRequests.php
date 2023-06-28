<?php

namespace ResourceLayer\Resources\Concerns;

use Illuminate\Support\Str;

trait HasRequests
{
    /**
     * @inheritDoc
     */
    public function getRouteParam(): string
    {
        return strtolower(
            Str::slug($this->getSingularResourceType())
        );
    }
}
