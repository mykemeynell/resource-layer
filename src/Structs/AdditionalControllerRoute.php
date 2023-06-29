<?php

namespace ResourceLayer\Structs;

/**
 * @property array{
 *     paramInRoute: boolean
 * } $config
 */
final class AdditionalControllerRoute
{
    public readonly string $routePath;

    public function __construct(
        public readonly string $verb,
        public readonly string $singularResourceType,
        public readonly string $resourceAction,
        public readonly string $controllerMethodName,
        public readonly string $routeName,
        public readonly string $controller,
        public readonly array $config
    ) {
        // Calculate the route path based on given arguments
        $this->routePath = $this->config['paramInRoute']
            ? sprintf("%s/{%s}/%s", $this->singularResourceType, $this->singularResourceType, $this->resourceAction)
            : sprintf("%s/%s", $this->singularResourceType, $this->resourceAction);
    }
}
