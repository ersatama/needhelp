<?php

namespace App\Models;

use App\Domain\Contracts\WooppayContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wooppay extends Model
{
    use HasFactory;

    protected $table    =   WooppayContract::TABLE;
    protected $fillable =   WooppayContract::FILLABLE;
}
