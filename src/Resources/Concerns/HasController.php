<?php

namespace ResourceLayer\Resources\Concerns;

use ResourceLayer\Exceptions;

trait HasController
{
    /**
     * @inheritDoc
     *
     * @throws Exceptions\ResourceControllerTypeInvalidException
     * @throws Exceptions\ResourceControllerDoesNotExistException
     * @throws Exceptions\NoResourceControllerSetException
     */
    public function getController(): string
    {
        if(!property_exists($this, 'controller')) {
            throw new Exceptions\NoResourceControllerSetException(sprintf("Controller property has not been set on [%s]", static::class));
        }

        if(!is_string($this->controller)) {
            throw new Exceptions\ResourceControllerTypeInvalidException(sprintf("Controller property on [%s] must be of type string, [%s] found", static::class, get_class($this->controller)));
        }

        if(!class_exists($this->controller)) {
            throw new Exceptions\ResourceControllerDoesNotExistException(sprintf("Controller on resource [%s] does not exist", static::class));
        }

        return $this->controller;
    }
}
