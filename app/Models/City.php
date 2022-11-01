<?php

namespace App\Models;

use App\Domain\Contracts\CityContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use CrudTrait, HasFactory;

    protected $table    =   CityContract::TABLE;
    protected $fillable =   CityContract::FILLABLE;

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
