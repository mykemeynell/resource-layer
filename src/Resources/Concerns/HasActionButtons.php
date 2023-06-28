<?php

namespace ResourceLayer\Resources\Concerns;

/**
 * @property array $actionButtons
 */
trait HasActionButtons
{
    /**
     * @inheritDoc
     */
    public function getActionButtons(): array
    {
        if(!property_exists($this, 'actionButtons')) {
            return [];
        }

        return $this->actionButtons;
    }
}
