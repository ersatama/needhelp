<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\NotificationContract;
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
        Schema::create(NotificationContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(Contract::USER_ID);
            $table->tinyInteger(Contract::TYPE)->default(1)->nullable();
            $table->unsignedBigInteger(Contract::QUESTION_ID)->nullable();
            $table->unsignedBigInteger(Contract::NOTIFICATION_GLOBAL_ID)->nullable();
            $table->boolean(Contract::STATUS)->default(true)->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists(NotificationContract::TABLE);
    }
};
