<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;


class OrganizationController extends Controller
{
    #[OA\Get(
        path: "/api/organizations/{organization}",
        summary: "Get detailed information about a specific organization",
        security: [["apiKey" => []]],
        tags: ["Organizations"],
        parameters: [
            new OA\Parameter(
                name: "organization",
                description: "ID организации",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Детальная информация об организации",
                content: new OA\JsonContent(ref: "#/components/schemas/OrganizationResource")
            ),
            new OA\Response(
                response: 404,
                description: "Организация не найдена"
            ),
            new OA\Response(
                response: 401,
                description: "Неавторизованный доступ"
            )
        ]
    )]
    public function getOrganization(){}

    #[OA\Get(
        path: "/api/organizations",
        summary: "Get list of organizations with filtering options",
        security: [["apiKey" => []]],
        tags: ["Organizations"],
        parameters: [
            new OA\Parameter(
                name: "name",
                description: "Фильтр по названию организации",
                in: "query",
                schema: new OA\Schema(type: "string")
            ),
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
                description: "Список организаций с фильтрацией",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/OrganizationResource")
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
