<?php

namespace ResourceLayer\Resources\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use ResourceLayer\Exceptions;
use ResourceLayer\Structs\AdditionalControllerRoute;

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

    /**
     * @inheritDoc
     */
    public function getControllerOnlyMethods(): array
    {
        if(!property_exists($this, 'controllerOnlyMethods')) {
            return [];
        }

        return $this->controllerOnlyMethods;
    }

    /**
     * @inheritDoc
     */
    public function getControllerExceptMethods(): array
    {
        if(!property_exists($this, 'controllerExceptMethods')) {
            return [];
        }

        return $this->controllerExceptMethods;
    }

    /**
     * @inheritDoc
     * @throws Exceptions\NoResourceControllerSetException
     * @throws Exceptions\ResourceControllerDoesNotExistException
     * @throws Exceptions\ResourceControllerTypeInvalidException
     * @throws Exceptions\AttemptToRegisterDuplicateAdditionalControllerMethodsException
     * @throws Exceptions\IllegalRouteVerbException
     * @throws Exceptions\MissingMethodNameOnAdditionalRouteArrayDeclarationException
     */
    public function getAdditionalControllerMethods(): array
    {
        if(!property_exists($this, 'controllerAdditionalMethods')) {
            return [];
        }

        $methods = $this->controllerAdditionalMethods;
        $extraMethods = [];

        foreach($methods as $verb => $extra) {
            $verb = trim(strtolower($verb));

            if(!in_array($verb, ['get', 'put', 'post', 'patch', 'delete', 'options'])) {
                throw new Exceptions\IllegalRouteVerbException(
                    sprintf("The verb [%s] cannot be registered here", $verb)
                );
            }

            foreach($extra as $name => $nameOnController) {
                $config = [
                    'paramInRoute' => false,
                ];

                if(is_array($nameOnController)) {
                    if(!array_key_exists('method', $nameOnController)) {
                        throw new Exceptions\MissingMethodNameOnAdditionalRouteArrayDeclarationException(
                            sprintf("A method name must be declared when specifying an additional resource route as an array on [%s]", static::class)
                        );
                    }

                    $config['paramInRoute'] = array_key_exists('passRouteParam', $nameOnController)
                        && (bool)$nameOnController['passRouteParam'] === true;

                    $nameOnController = $nameOnController['method'];
                }

                $resourceAction = !is_numeric($name) ? $name : $nameOnController;
                $routeName = "{$this->getSingularResourceType()}.{$resourceAction}";

                if(Route::has($routeName)) {
                    throw new Exceptions\AttemptToRegisterDuplicateAdditionalControllerMethodsException(
                        sprintf("A route with the name [%s] has already been registered", $routeName)
                    );
                }

                if(Arr::exists($extraMethods, "{$verb}.{$resourceAction}")) {
                    throw new Exceptions\AttemptToRegisterDuplicateAdditionalControllerMethodsException(
                        sprintf("The %s method [%s] has already been registered against the [%s] controller", strtoupper($verb), $routeName, $this->getController())
                    );
                }

                $extraMethods = Arr::add($extraMethods, $verb, new AdditionalControllerRoute(
                    verb: $verb,
                    singularResourceType: $this->getSingularResourceType(),
                    resourceAction: $resourceAction,
                    controllerMethodName: $nameOnController,
                    routeName: $routeName,
                    controller: $this->getController(),
                    config: $config
                ));
            }
        }

        return $extraMethods;
    }
}
