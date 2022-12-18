<?php

namespace App\Models;

use App\Domain\Contracts\PriceContract;
use App\Domain\Scopes\Page;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table    =   PriceContract::TABLE;
    protected $fillable =   PriceContract::FILLABLE;

    protected static function booted(): void
    {
        static::addGlobalScope(new Page);
    }
}
