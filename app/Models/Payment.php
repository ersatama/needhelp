<?php

namespace App\Models;

use App\Domain\Contracts\PaymentContract;
use App\Domain\Scopes\Page;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table    =   PaymentContract::TABLE;
    protected $fillable =   PaymentContract::FILLABLE;

    protected static function booted(): void
    {
        static::addGlobalScope(new Page);
    }
}
