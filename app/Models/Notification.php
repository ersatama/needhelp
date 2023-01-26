<?php

namespace App\Models;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\NotificationContract;
use App\Domain\Scopes\OrderBy;
use App\Domain\Scopes\Page;
use App\Domain\Scopes\Type;
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
        static::addGlobalScope(new OrderBy);
        static::addGlobalScope(new Type);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class)->withoutGlobalScopes([Page::class, OrderBy::class]);
    }

    public function notificationGlobal(): BelongsTo
    {
        return $this->belongsTo(NotificationGlobal::class, Contract::NOTIFICATION_GLOBAL_ID, Contract::ID)
            ->withoutGlobalScopes([Page::class, OrderBy::class]);
    }
}
