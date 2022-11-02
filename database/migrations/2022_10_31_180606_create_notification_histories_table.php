<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\NotificationHistoryContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(NotificationHistoryContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(Contract::NOTIFICATION_ID)->nullable();
            $table->unsignedBigInteger(Contract::USER_ID)->nullable();
            $table->text(Contract::MESSAGE)->nullable();
            $table->boolean(Contract::VIEW)->default(false)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(Contract::NOTIFICATION_ID);
            $table->index(Contract::USER_ID);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(NotificationHistoryContract::TABLE);
    }
};
