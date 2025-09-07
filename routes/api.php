<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::middleware('api.key')->group(function () {
   Route::prefix('buildings')->group(function () {
       Route::prefix('{building}')->group(function (){
          Route::get('organizations', [BuildingController::class, 'getOrganizations']);
       });
       Route::get('/', [BuildingController::class, 'list']);
   });

   Route::prefix('activities')->group(function () {
       Route::prefix('{activity}')->group(function (){
           Route::get('organizations', [ActivityController::class, 'getOrganizations']);
           Route::get('organizations-by-parent', [ActivityController::class, 'getOrganizationsByParent']);
           Route::get('can-have-sub-activities', [ActivityController::class, 'canHaveSubActivities']);
       });
   });

    Route::prefix('organizations')->group(function () {
        Route::get('/', [OrganizationController::class, 'list']);
        Route::prefix('{organization}')->group(function (){
            Route::get('/', [OrganizationController::class, 'getOrganization']);
        });
    });
});
