<?php

namespace ResourceLayer\Resources\Contracts;

/**
 * @property bool $showInNavigation
 * @property string $navigationIcon
 * @property string $navigationGroup
 * @property string $navigationDisplayName
 */
interface WithNavigation
{
    /**
     * Flag for whether the resource can be processed in navigation.
     *
     * @return bool
     */
    public function showInNavigation(): bool;

    /**
     * Get the value of the $navigationIcon property.
     *
     * @return null|string
     */
    public function getNavigationIcon(): ?string;

    /**
     * Get the navigation group that a resource belongs to.
     *
     * @return string|null
     */
    public function getNavigationGroup(): ?string;

    /**
     * Returns the navigation display name.
     *
     * @return string
     */
    public function getNavigationDisplayName(): string;
}
