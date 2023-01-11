<?php

namespace App\Models;

use App\Domain\Contracts\NotificationContract;
use App\Domain\Scopes\Page;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory, HasEvents;
    protected $table    =   NotificationContract::TABLE;
    protected $fillable =   NotificationContract::FILLABLE;

    protected static function booted(): void
    {
        static::addGlobalScope(new Page);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class)->withoutGlobalScope(Page::class);
    }
}
