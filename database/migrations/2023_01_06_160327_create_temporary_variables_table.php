<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\TemporaryVariableContract;
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
        Schema::create(TemporaryVariableContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Contract::KEY)->unique();
            $table->text(Contract::VALUE)->nullable();
            $table->dateTime(Contract::EXPIRE_AT)->useCurrent();
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
        Schema::dropIfExists(TemporaryVariableContract::TABLE);
    }
};
