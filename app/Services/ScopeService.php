<?php

namespace App\Services;

class ScopeService
{
    public function getScopeByPoint(int|float $radius, float $latitude, float $longitude): array
    {
        return [
            'west' => $this->calculateLongitude(-$radius, $longitude),
            'east' => $this->calculateLongitude($radius, $longitude),
            'north' => $this->calculateLatitude($radius, $latitude),
            'south' => $this->calculateLatitude(-$radius, $latitude),
        ];
    }

    protected function calculateLatitude(int|float $num, float $latitude): float
    {
        $newLatitude = $latitude + $num;

        if ($newLatitude > 90) {
            $newLatitude = 90;
        } elseif ($newLatitude < -90) {
            $newLatitude = -90;
        }

        return $newLatitude;
    }

    protected function calculateLongitude(int|float $num, float $longitude): float
    {
        $newLongitude = $longitude + $num;

        if ($newLongitude > 180) {
            $dif = $newLongitude - 180;

            $newLongitude = -180 + $dif;
        } elseif ($newLongitude < -180) {
            $dif = $newLongitude + 180;

            $newLongitude = 180 - $dif;
        }

        return $newLongitude;
    }
}
