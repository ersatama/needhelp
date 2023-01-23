<?php

namespace App\Models;

use App\Domain\Contracts\NotificationGlobalContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationGlobal extends Model
{
    use HasFactory, CrudTrait;

    protected $table    =   NotificationGlobalContract::TABLE;
    protected $fillable =   NotificationGlobalContract::FILLABLE;

}
