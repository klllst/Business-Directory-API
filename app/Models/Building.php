<?php

namespace App\Models;

use App\Services\ScopeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property array $address
 * @property float $latitude
 * @property float $longitude
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read Collection|Organization[] $organizations
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Building newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Building query()
 * @method static \Illuminate\Database\Eloquent\Builder|Builder filter(Request $request)
 */
class Building extends Model
{
    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'address' => 'array',
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    public function scopeFilter(Builder $query, Request $request): void
    {
        $scopeService = app(ScopeService::class);

        $query->when($request->has(['radius', 'latitude', 'longitude']), function (Builder $query) use ($request, $scopeService) {
                $scopeCoordinates = $scopeService->getScopeByPoint(
                    $request->query('radius'),
                    $request->query('latitude'),
                    $request->query('longitude')
                );

                $query->where('longitude', '>=', $scopeCoordinates['west'])
                    ->where('longitude', '<=', $scopeCoordinates['east'])
                    ->where('latitude', '<=', $scopeCoordinates['north'])
                    ->where('latitude', '>=', $scopeCoordinates['south']);
            });
    }
}
