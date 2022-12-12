<?php

namespace App\Models;

use App\Domain\Contracts\PhoneCodeContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCode extends Model
{
    use HasFactory;

    protected $table    =   PhoneCodeContract::TABLE;
    protected $fillable =   PhoneCodeContract::FILLABLE;
}
