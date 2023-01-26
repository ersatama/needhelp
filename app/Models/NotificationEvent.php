<?php

namespace App\Models;

use App\Domain\Contracts\NotificationEventContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationEvent extends Model
{
    use HasFactory;
    protected $table    =   NotificationEventContract::TABLE;
    protected $fillable =   NotificationEventContract::FILLABLE;
}
