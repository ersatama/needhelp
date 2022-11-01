<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\CountryContract;
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
        Schema::create(CountryContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Contract::TITLE)->nullable();
            $table->string(Contract::TITLE_KZ)->nullable();
            $table->string(Contract::TITLE_EN)->nullable();
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
        Schema::dropIfExists(CountryContract::TABLE);
    }
};
