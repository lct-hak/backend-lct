<?php

namespace App\Http\Controllers\Documentation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '0.1', description: 'Mos-Dolgoletie API Documentation', title: 'Mos-Dolgoletie'
)]
class DocumentationController extends Controller
{
    public function index()
    {
        $openapi = \OpenApi\Generator::scan(['/var/www/app']);

        return $openapi->toYaml();
    }
}
