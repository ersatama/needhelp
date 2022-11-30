<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Domain\Contracts\Contract;
use App\Domain\Contracts\UserContract;
use App\Domain\Scopes\Page;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;

    protected $table    =   UserContract::TABLE;
    protected $fillable =   UserContract::FILLABLE;
    protected $hidden   =   UserContract::HIDDEN;
    protected $casts    =   UserContract::CASTS;

    protected static function booted(): void
    {
        static::addGlobalScope(new Page);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function setPasswordAttribute($pass)
    {
        $this->attributes[Contract::PASSWORD] = Hash::make($pass);
    }

    public function getFullnameAttribute()
    {
        return $this->{Contract::ID} . ' - ' . $this->{Contract::NAME} . ' ' . $this->{Contract::SURNAME};
    }
}
