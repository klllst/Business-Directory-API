<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Models\Activity;
use App\Models\Organization;
use App\Services\ActivityService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    public function getOrganizations(Activity $activity): JsonResponse
    {
        $activity->load([
            'organizations.building',
            'organizations.phones',
            'organizations.activities',
        ]);

        return response()->json(OrganizationResource::collection($activity->organizations));
    }

    public function getOrganizationsByParent(Activity $activity, ActivityService $activityService): JsonResponse
    {
        $activityIds = $activityService
            ->getAllSubActivities($activity)
            ->pluck('id');

        $organizations = Organization::query()->whereHas('activities', function (Builder $query) use ($activityIds) {
           $query->whereIn('id', $activityIds);
        })->with([
            'building',
            'activities',
            'phones',
        ])->get();

        return response()->json(OrganizationResource::collection($organizations));
    }

    public function canHaveSubActivities(Activity $activity, ActivityService $activityService): JsonResponse
    {
        return response()->json([
            'result' => $activityService->checkCanHaveSubActivities($activity),
        ]);
    }
}
