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
            $table->unsignedBigInteger(Contract::USER_ID)->nullable();
            $table->string(Contract::TITLE)->nullable();
            $table->text(Contract::DESCRIPTION)->nullable();
            $table->boolean(Contract::IS_IMPORTANT)->default(false)->nullable();
            $table->boolean(Contract::IS_PAID)->default(false)->nullable();
            $table->timestamps();
            $table->softDeletes();
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
