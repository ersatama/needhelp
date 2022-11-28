<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\UserContract;
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
        Schema::create(UserContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger(Contract::LANGUAGE_ID)->nullable()->default(1);
            $table->unsignedInteger(Contract::REGION_ID)->nullable();
            $table->unsignedInteger(Contract::CITY_ID)->nullable();
            $table->enum(Contract::ROLE, [
                Contract::ADMIN,
                Contract::LAWYER,
                Contract::MANAGER,
                Contract::USER
            ])->default(Contract::USER);
            $table->string(Contract::NAME);
            $table->string(Contract::SURNAME);
            $table->string(Contract::LAST_NAME)->nullable();
            $table->enum(Contract::GENDER,[
                Contract::MALE,
                Contract::FEMALE
            ])->nullable();
            $table->date(Contract::BIRTHDATE)->nullable();
            $table->string(Contract::PHONE,20)->unique()->nullable();
            $table->char(Contract::PHONE_CODE,4)->nullable();
            $table->timestamp(Contract::PHONE_VERIFIED_AT)->nullable();
            $table->string(Contract::EMAIL)->unique()->nullable();
            $table->char(Contract::EMAIL_CODE,4)->nullable();
            $table->timestamp(Contract::EMAIL_VERIFIED_AT)->nullable();
            $table->string(Contract::PASSWORD);
            $table->boolean(Contract::PUSH_NOTIFICATION)->default(false)->nullable();
            $table->timestamp(Contract::BLOCKED_AT)->nullable();
            $table->string(Contract::BLOCKED_REASON)->nullable();
            $table->timestamp(Contract::LAST_AUTH)->useCurrent();
            $table->rememberToken();
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
        Schema::dropIfExists(UserContract::TABLE);
    }
};
