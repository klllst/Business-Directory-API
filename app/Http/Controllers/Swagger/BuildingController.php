<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

class BuildingController extends Controller
{
    #[OA\Get(
        path: "/api/buildings/{building}/organizations",
        summary: "Get organizations in a specific building",
        security: [["apiKey" => []]],
        tags: ["Buildings"],
        parameters: [
            new OA\Parameter(
                name: "building",
                description: "ID здания",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список организаций в здании",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/OrganizationResource")
                )
            ),
            new OA\Response(
                response: 404,
                description: "Здание не найдено"
            ),
            new OA\Response(
                response: 401,
                description: "Неавторизованный доступ"
            )
        ]
    )]
    public function getOrganizations(){}

    #[OA\Get(
        path: "/api/buildings",
        summary: "Get list of buildings with filtering",
        security: [["apiKey" => []]],
        tags: ["Buildings"],
        parameters: [
            new OA\Parameter(
                name: "latitude",
                description: "Широта точки для поиска по радиусу",
                in: "query",
                schema: new OA\Schema(type: "number", format: "float")
            ),
            new OA\Parameter(
                name: "longitude",
                description: "Долгота точки для поиска по радиусу",
                in: "query",
                schema: new OA\Schema(type: "number", format: "float")
            ),
            new OA\Parameter(
                name: "radius",
                description: "Радиус поиска",
                in: "query",
                schema: new OA\Schema(type: "number", format: "float", minimum: 0.0001)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список зданий с организациями",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/BuildingResource")
                )
            ),
            new OA\Response(
                response: 401,
                description: "Неавторизованный доступ"
            ),
            new OA\Response(
                response: 422,
                description: "Ошибки валидации",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "The given data was invalid."
                        ),
                        new OA\Property(
                            property: "errors",
                            properties: [
                                new OA\Property(
                                    property: "latitude",
                                    type: "array",
                                    items: new OA\Items(type: "string")
                                ),
                                new OA\Property(
                                    property: "longitude",
                                    type: "array",
                                    items: new OA\Items(type: "string")
                                ),
                                new OA\Property(
                                    property: "radius",
                                    type: "array",
                                    items: new OA\Items(type: "string")
                                )
                            ],
                            type: "object"
                        )
                    ]
                )
            )
        ]
    )]
    public function list(){}
}
