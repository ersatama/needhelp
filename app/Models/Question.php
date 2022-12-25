<?php

namespace App\Models;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\QuestionContract;
use App\Domain\Scopes\OrderBy;
use App\Domain\Scopes\Page;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory, CrudTrait, HasEvents;

    protected $table    =   QuestionContract::TABLE;
    protected $fillable =   QuestionContract::FILLABLE;

    protected static function booted(): void
    {
        static::addGlobalScope(new Page);
        static::addGlobalScope(new OrderBy);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withoutGlobalScope(Page::class);
    }

    public function lawyer(): BelongsTo
    {
        return $this->belongsTo(User::class, Contract::LAWYER_ID, Contract::ID)->withoutGlobalScope(Page::class);
    }
}
