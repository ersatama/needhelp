<?php

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\QuestionContract;
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
        Schema::create(QuestionContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(Contract::USER_ID)->nullable();
            $table->unsignedBigInteger(Contract::LAWYER_ID)->nullable();
            $table->unsignedInteger(Contract::CURRENCY_ID)->default(1);
            $table->string(Contract::PAYMENT_ID)->nullable();
            $table->bigInteger(Contract::PRICE)->nullable()->default(0);
            $table->string(Contract::TITLE)->nullable();
            $table->text(Contract::DESCRIPTION)->nullable();
            $table->text(Contract::ANSWER)->nullable();
            $table->boolean(Contract::IS_IMPORTANT)->default(false)->nullable();
            $table->boolean(Contract::IS_PAID)->default(false)->nullable();
            $table->tinyInteger(Contract::STATUS)->default(1);
            $table->boolean(Contract::IS_NEW)->default(true)->nullable();
            $table->timestamp(Contract::ANSWERED_AT)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(Contract::USER_ID);
            $table->index(Contract::LAWYER_ID);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(QuestionContract::TABLE);
    }
};
