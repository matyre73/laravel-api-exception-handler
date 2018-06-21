<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Generic Error Format
    |--------------------------------------------------------------------------
    |
    | When some HTTP exceptions are not caught and dealt with the API will
    | generate a generic error response in the format provided. Any
    | keys that aren't replaced with corresponding values will be
    | removed from the final response.
    |
    */
    'errorFormat' => [
        'message' => ':message',
        'errors' => ':errors',
        'code' => ':code',
        'status_code' => ':status_code',
        'debug' => ':debug',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Exception Types
    |--------------------------------------------------------------------------
    |
    | Customize the exception types to against.
    |
    */
    'exceptionTypes' => [
        'http' => [
            'instance' => Symfony\Component\HttpKernel\Exception\HttpException::class,
            'status_code' => null,
        ],
        'validation' => [
            'instance' => Dotenv\Exception\ValidationException::class,
            'status_code' => \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY,
        ],
        'error401' => [
            'instance' => Cashrewards\MultiTenant\Exceptions\Error401::class,
            'status_code' => \Illuminate\Http\Response::HTTP_UNAUTHORIZED,
        ],
        'error403' => [
            'instance' => Cashrewards\MultiTenant\Exceptions\Error403::class,
            'status_code' => \Illuminate\Http\Response::HTTP_FORBIDDEN,
        ],
        'error500' => [
            'instance' => Cashrewards\MultiTenant\Exceptions\Error500::class,
            'status_code' => \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR,
        ],
    ]
];