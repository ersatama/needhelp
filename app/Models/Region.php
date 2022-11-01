<?php

namespace App\Models;

use App\Domain\Contracts\RegionContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Region extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $table    =   RegionContract::TABLE;
    protected $fillable =   RegionContract::FILLABLE;

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
