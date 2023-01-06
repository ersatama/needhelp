<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\WooppayContract;
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
        Schema::create(WooppayContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger(Contract::QUESTION_ID);
            $table->unsignedBigInteger(Contract::OPERATION_ID)->unique();
            $table->unsignedBigInteger(Contract::INVOICE_ID)->unique()->nullable();
            $table->string(Contract::REPLENISHMENT_ID)->nullable();
            $table->string(Contract::KEY)->nullable();
            $table->text(Contract::URL)->nullable();
            $table->boolean(Contract::STATUS)->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(WooppayContract::TABLE);
    }
};
