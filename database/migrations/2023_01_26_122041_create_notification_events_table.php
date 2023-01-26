<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\NotificationEventContract;
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
        Schema::create(NotificationEventContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(Contract::QUESTION_ID);
            $table->boolean(Contract::IS_PAID);
            $table->unsignedTinyInteger(Contract::STATUS);
            $table->timestamps();
            $table->index(Contract::QUESTION_ID);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(NotificationEventContract::TABLE);
    }
};
