<?php

namespace App\Models;

use App\Services\ScopeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property string $name
 * @property int $building_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read Building $building
 * @property-read Collection|OrganizationPhone[] $phones
 * @property-read Collection|Activity[] $activities
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization filter(Request $request)
 */
class Organization extends Model
{
    protected $fillable = [
        'name',
        'building_id',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(OrganizationPhone::class);
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class);
    }

    public function scopeFilter(Builder $query, Request $request): void
    {
        $scopeService = app(ScopeService::class);

        $query->when($request->has('name'), function (Builder $query) use ($request) {
            $searchName = strtolower($request->query('name'));

            $query->whereRaw('LOWER(name) LIKE ?', ["%{$searchName}%"]);
        })
        ->when($request->has(['radius', 'latitude', 'longitude']), function (Builder $query) use ($request, $scopeService) {
            $scopeCoordinates = $scopeService->getScopeByPoint(
                $request->query('radius'),
                $request->query('latitude'),
                $request->query('longitude')
            );

            $query->whereHas('building', function (Builder $query) use ($scopeCoordinates) {
                $query->where('longitude', '>=', $scopeCoordinates['west'])
                    ->where('longitude', '<=', $scopeCoordinates['east'])
                    ->where('latitude', '<=', $scopeCoordinates['north'])
                    ->where('latitude', '>=', $scopeCoordinates['south']);
            });
        });
    }
}
