<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0.0", description: "business directory api", title: "Business Directory Api"),
    OA\Server(url: 'http://webserver:7020', description: "local server"),
]
abstract class Controller
{
    //
}
