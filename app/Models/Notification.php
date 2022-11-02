<?php

namespace App\Models;

use App\Domain\Contracts\NotificationContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, CrudTrait;

    protected $table    =   NotificationContract::TABLE;
    protected $fillable =   NotificationContract::FILLABLE;
}
