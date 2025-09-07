<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Collection;

class ActivityService
{
    public function checkCanHaveSubActivities(Activity $activity): bool
    {
        $level = 1;

        while (isset($activity->parent)) {
            $activity = $activity->parent;
            ++$level;
        }

        return $level < Activity::MAX_LEVEL;
    }

    public function getAllSubActivities(Activity $activity): Collection
    {
        $activities = collect()->push($activity);

        return $this->addSubActivities($activity, $activities, 1);
    }

    public function addSubActivities(Activity $activity, Collection $activities, int $currentLevel): Collection
    {
        if ($currentLevel > Activity::MAX_LEVEL) {
            return $activities;
        }

        $activity->load('children');

        if ($activity->children->isNotEmpty()) {
            ++$currentLevel;
            $activity->children->each(function ($subActivity) use ($activities, $currentLevel) {
                $activities->push($subActivity);
                $this->addSubActivities($subActivity, $activities, $currentLevel);
            });
        }

        return $activities;
    }
}
