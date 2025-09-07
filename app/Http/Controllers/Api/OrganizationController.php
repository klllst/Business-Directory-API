<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationListRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    public function getOrganization(Organization $organization): JsonResponse
    {
        $organization->load([
            'activities',
            'building',
            'phones',
        ]);

        return response()->json(new OrganizationResource($organization));
    }

    public function list(OrganizationListRequest $request): JsonResponse
    {
        $organizations = Organization::filter($request)
            ->with(['building', 'phones', 'activities'])
            ->get();

        return response()->json(OrganizationResource::collection($organizations));
    }
}
