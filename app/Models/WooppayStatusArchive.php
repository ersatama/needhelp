<?php

namespace App\Models;

use App\Domain\Contracts\WooppayStatusArchiveContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WooppayStatusArchive extends Model
{
    use HasFactory;
    protected $table    =   WooppayStatusArchiveContract::TABLE;
    protected $fillable =   WooppayStatusArchiveContract::FILLABLE;
}
