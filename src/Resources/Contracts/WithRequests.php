<?php

namespace ResourceLayer\Resources\Contracts;

interface WithRequests
{
    /**
     * Get the route parameter name.
     *
     * @return string
     */
    public function getRouteParam(): string;
}
