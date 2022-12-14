<?php

namespace App\Models;

use App\Domain\Contracts\UserDeletedContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeleted extends Model
{
    use HasFactory;

    protected $table    =   UserDeletedContract::TABLE;
    protected $fillable =   UserDeletedContract::FILLABLE;

    public function getCreatedAtAttribute($date): string
    {
        return Carbon::parse($date)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($date): string
    {
        return Carbon::parse($date)->format('Y-m-d H:i:s');
    }

    public function getDeletedAtAttribute($date): ?string
    {
        if ($date) {
            return Carbon::parse($date)->format('Y-m-d H:i:s');
        }
        return null;
    }
}
