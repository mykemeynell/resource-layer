<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Base Resource
    |--------------------------------------------------------------------------
    |
    | This is the class that is extended by default by other resources. Should
    | really be an abstract class as this isn't a resource itself.
    |
    */
    'base_resource' => \ResourceLayer\Resources\Resource::class,

    /*
    |--------------------------------------------------------------------------
    | Resource Class Suffix
    |--------------------------------------------------------------------------
    |
    | Appended to the end of newly created resource classes. For example;
    | creating a Customer resource - the created class would
    | be named CustomerResource.
    |
    */
    'resource_suffix' => 'Resource',

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | Array of generated resources that should be included when
    | the application boots.
    |
    */
    'resources' => []
];
