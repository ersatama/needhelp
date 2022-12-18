<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\PriceContract;
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
        Schema::create(PriceContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger(Contract::CURRENCY_ID)->nullable();
            $table->string(Contract::PRICE);
            $table->string(Contract::IMPORTANT_PRICE);
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
        Schema::dropIfExists(PriceContract::TABLE);
    }
};
