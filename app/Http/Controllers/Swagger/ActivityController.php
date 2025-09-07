<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

class ActivityController extends Controller
{
    #[OA\Get(
        path: "/api/activities/{activity}/organizations",
        summary: "Get organizations by specific activity",
        security: [["apiKey" => []]],
        tags: ["Activities"],
        parameters: [
            new OA\Parameter(
                name: "activity",
                description: "ID вида деятельности",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список организаций",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/OrganizationResource")
                )
            ),
            new OA\Response(
                response: 404,
                description: "Вид деятельности не найден"
            ),
            new OA\Response(
                response: 401,
                description: "Неавторизованный доступ"
            )
        ]
    )]
    public function getOrganizations() {}


    #[OA\Get(
        path: "/api/activities/{activity}/organizations-by-parent",
        summary: "Get organizations by activity with hierarchy",
        security: [["apiKey" => []]],
        tags: ["Activities"],
        parameters: [
            new OA\Parameter(
                name: "activity",
                description: "ID родительского вида деятельности",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список организаций с учетом иерархии видов деятельности",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/OrganizationResource")
                )
            ),
            new OA\Response(
                response: 404,
                description: "Вид деятельности не найден"
            ),
            new OA\Response(
                response: 401,
                description: "Неавторизованный доступ"
            )
        ]
    )]
    public function getOrganizationsByParent(){}

    #[OA\Get(
        path: "/api/activities/{activity}/can-have-sub-activities",
        summary: "Check if activity can have sub activities",
        security: [["apiKey" => []]],
        tags: ["Activities"],
        parameters: [
            new OA\Parameter(
                name: "activity",
                description: "ID вида деятельности",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Результат проверки",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "result", type: "boolean")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Вид деятельности не найден"
            ),
            new OA\Response(
                response: 401,
                description: "Неавторизованный доступ"
            )
        ]
    )]
    public function canHaveSubActivities(){}
}
