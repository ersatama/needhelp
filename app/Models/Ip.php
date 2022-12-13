<?php

namespace App\Models;

use App\Domain\Contracts\IpContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   IpContract::TABLE;
    protected $fillable =   IpContract::FILLABLE;
}
