<?php

namespace App\Http\Controllers\Documentation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class FortifyController extends Controller
{
    #[OA\Post(
        path: '/api/register',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', required: ['true'], type: 'string'),
                    new OA\Property(property: 'email', required: ['true'], type: 'string'),
                    new OA\Property(property: 'password', required: ['true'], type: 'string', minimum: 8),
                    new OA\Property(property: 'password_confirmation', required: ['true'], type: 'string', minimum: 8),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Created')
        ]
    )]
    public function register()
    {
    }

    #[OA\Post(
        path: '/api/login',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'email', required: ['true'], type: 'string'),
                    new OA\Property(property: 'password', required: ['true'], type: 'string')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Logged In', content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'success', type: 'boolean', default: 'true'),
                    new OA\Property(property: 'token', type: 'string')
                ]
            ))
        ]
    )]
    public function login()
    {
    }
}
