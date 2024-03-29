<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\PaymentContract;
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
        Schema::create(PaymentContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Contract::TITLE);
            $table->string(Contract::LOGIN);
            $table->string(Contract::PASSWORD);
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
        Schema::dropIfExists(PaymentContract::TABLE);
    }
};
