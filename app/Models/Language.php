<?php

namespace App\Models;

use App\Domain\Contracts\LanguageContract;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory, CrudTrait;
    protected $table    =   LanguageContract::TABLE;
    protected $fillable =   LanguageContract::FILLABLE;
}
