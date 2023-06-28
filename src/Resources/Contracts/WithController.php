<?php

namespace ResourceLayer\Resources\Contracts;

/**
 * @property string $controller
 */
interface WithController
{
    /**
     * Get the controller class name.
     *
     * @return string
     */
    public function getController(): string;
}
