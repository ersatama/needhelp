<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\PhoneCodeContract;
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
        Schema::create(PhoneCodeContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Contract::PHONE,20)->unique()->nullable();
            $table->char(Contract::CODE,6)->nullable();
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
        Schema::dropIfExists(PhoneCodeContract::TABLE);
    }
};
