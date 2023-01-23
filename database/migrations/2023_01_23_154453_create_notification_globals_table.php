<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\NotificationGlobalContract;
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
        Schema::create(NotificationGlobalContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->enum(Contract::ROLE, [
                Contract::ALL,
                Contract::ADMIN,
                Contract::MODERATOR,
                Contract::LAWYER,
                Contract::USER
            ])->nullable();
            $table->text(Contract::TEXT);
            $table->text(Contract::TEXT_KZ);
            $table->text(Contract::TEXT_EN);
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
        Schema::dropIfExists(NotificationGlobalContract::TABLE);
    }
};
