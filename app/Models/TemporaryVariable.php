<?php

namespace App\Models;

use App\Domain\Contracts\TemporaryVariableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryVariable extends Model
{
    use HasFactory;

    protected $table    =   TemporaryVariableContract::TABLE;
    protected $fillable =   TemporaryVariableContract::FILLABLE;

}
