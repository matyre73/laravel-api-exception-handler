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
    ]
];
