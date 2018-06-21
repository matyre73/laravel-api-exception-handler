<?php

use Illuminate\Http\Response;

return [
    'error' => [
        Response::HTTP_BAD_REQUEST => [
            'name' => 'Bad Request',
            'message' => 'The request cannot be fulfilled due to bad syntax.',
        ],
        Response::HTTP_UNAUTHORIZED => [
            'name'    => 'Unauthorized',
            'message' => 'Authentication is required and has failed or has not yet been provided.',
        ],
        Response::HTTP_FORBIDDEN => [
            'name'    => 'Forbidden',
            'message' => 'You do not have permission to perform that request.',
        ],
        Response::HTTP_NOT_FOUND => [
            'name'    => 'Not Found',
            'message' => 'The requested resource could not be found.',
        ],
        Response::HTTP_METHOD_NOT_ALLOWED => [
            'name'    => 'Method Not Allowed',
            'message' => 'A request was made of a resource using a request method not supported by that resource.',
        ],
        Response::HTTP_NOT_ACCEPTABLE => [
            'name'    => 'Not Acceptable',
            'message' => 'The requested resource is only capable of generating content not acceptable.',
        ],
        Response::HTTP_CONFLICT => [
            'name'    => 'Conflict',
            'message' => 'The request could not be processed because of a conflict in the request.',
        ],
        Response::HTTP_GONE => [
            'name'    => 'Gone',
            'message' => 'The requested resource is no longer available and will not be available again.',
        ],
        Response::HTTP_LENGTH_REQUIRED => [
            'name'    => 'Length Required',
            'message' => 'The request did not specify the length of its content, which is required by the requested resource.',
        ],
        Response::HTTP_PRECONDITION_FAILED => [
            'name'    => 'Precondition Failed',
            'message' => 'The server does not meet one of the preconditions that the requester put on the request.',
        ],
        Response::HTTP_UNSUPPORTED_MEDIA_TYPE => [
            'name'    => 'Unsupported Media Type',
            'message' => 'The request entity has a media type which the server or resource does not support.',
        ],
        Response::HTTP_UNPROCESSABLE_ENTITY => [
            'name'    => 'Unprocessable Entity',
            'message' => 'The request was well-formed but was unable to be followed due to semantic errors.',
        ],
        Response::HTTP_PRECONDITION_REQUIRED => [
            'name'    => 'Precondition Required',
            'message' => 'The origin server requires the request to be conditional.',
        ],
        Response::HTTP_TOO_MANY_REQUESTS => [
            'name'    => 'Too Many Requests',
            'message' => 'The user has sent too many requests in a given amount of time.',
        ],
        Response::HTTP_INTERNAL_SERVER_ERROR => [
            'name'    => 'Internal Server Error',
            'message' => 'An error has occurred and this resource cannot be displayed.',
        ],
        Response::HTTP_NOT_IMPLEMENTED => [
            'name'    => 'Not Implemented',
            'message' => 'The server either does not recognize the request method, or it lacks the ability to fulfil the request.',
        ],
        Response::HTTP_BAD_GATEWAY => [
            'name'    => 'Bad Gateway',
            'message' => 'The server was acting as a gateway or proxy and received an invalid response from the upstream server.',
        ],
        Response::HTTP_SERVICE_UNAVAILABLE => [
            'name'    => 'Service Unavailable',
            'message' => 'The server is currently unavailable. It may be overloaded or down for maintenance.',
        ],
        Response::HTTP_GATEWAY_TIMEOUT => [
            'name'    => 'Gateway Timeout',
            'message' => 'The server was acting as a gateway or proxy and did not receive a timely response from the upstream server.',
        ],
        Response::HTTP_VERSION_NOT_SUPPORTED => [
            'name'    => 'HTTP Version Not Supported',
            'message' => 'The server does not support the HTTP protocol version used in the request.',
        ]
    ]
];