<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\IpContract;
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
        Schema::create(IpContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Contract::IP)->unique();
            $table->string(Contract::TITLE)->nullable();
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
        Schema::dropIfExists(IpContract::TABLE);
    }
};
