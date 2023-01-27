<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\WooppayStatusArchiveContract;
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
        Schema::create(WooppayStatusArchiveContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(Contract::OPERATION_ID);
            $table->text(Contract::DATA)->nullable();
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
        Schema::dropIfExists(WooppayStatusArchiveContract::TABLE);
    }
};
