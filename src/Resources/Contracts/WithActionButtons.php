<?php

namespace ResourceLayer\Resources\Contracts;

interface WithActionButtons
{
    /**
     * Gets the action buttons array from a resource.
     *
     * @return array
     */
    public function getActionButtons(): array;
}
