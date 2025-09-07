<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $number
 * @property int $organization_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read Organization $organization
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationPhone whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationPhone whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationPhone query()
 */
class OrganizationPhone extends Model
{
    protected $fillable = [
        'number',
        'organization_id',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
