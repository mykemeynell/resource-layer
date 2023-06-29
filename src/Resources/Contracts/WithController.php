<?php

namespace ResourceLayer\Resources\Contracts;

use ResourceLayer\Structs\AdditionalControllerRoute;

/**
 * @property string $controller
 * @property array $controllerOnlyMethods
 * @property array $controllerExceptMethods
 * @property array<string|int, string|array{
 *      method: string,
 *      passRouteParam: bool
 *  }> $controllerAdditionalMethods
 */
interface WithController
{
    /**
     * Get the controller class name.
     *
     * @return string
     */
    public function getController(): string;

    /**
     * Get the methods that should only be registered on the controller.
     *
     * @return array
     */
    public function getControllerOnlyMethods(): array;

    /**
     * Get the methods that should not be registered on the controller.
     *
     * @return array
     */
    public function getControllerExceptMethods(): array;

    /**
     * Get any additional methods that should be registered against the controller.
     *
     * @return array<int, AdditionalControllerRoute>
     */
    public function getAdditionalControllerMethods(): array;

    /**
     * Get the singular resource name.
     *
     * @return string
     */
    public function getSingularResourceType(): string;
}
