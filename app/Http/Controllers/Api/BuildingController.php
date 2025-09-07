<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingListRequest;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\OrganizationResource;
use App\Models\Building;
use Illuminate\Http\JsonResponse;

class BuildingController extends Controller
{
    public function getOrganizations(Building $building): JsonResponse
    {
        $building->load([
            'organizations.phones',
            'organizations.activities',
        ]);

        return response()->json(OrganizationResource::collection($building->organizations));
    }

    public function list(BuildingListRequest $request): JsonResponse
    {
        $buildings = Building::filter($request)
            ->with(['organizations.phones', 'organizations.building', 'organizations.activities'])
            ->get();

        return response()->json(BuildingResource::collection($buildings));
    }
}
