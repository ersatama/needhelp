<?php

namespace App\Models;

use App\Domain\Contracts\LanguageContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $table    =   LanguageContract::TABLE;
    protected $fillable =   LanguageContract::FILLABLE;
}
