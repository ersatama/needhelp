<?php

namespace App\Models;

use App\Domain\Contracts\NotificationHistoryContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationHistory extends Model
{
    use HasFactory, CrudTrait;
    protected $table    =   NotificationHistoryContract::TABLE;
    protected $fillable =   NotificationHistoryContract::FILLABLE;
}
