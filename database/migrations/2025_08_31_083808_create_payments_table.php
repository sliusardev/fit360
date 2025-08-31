<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->index();
            $table->string('entity_type')->nullable();
            $table->bigInteger('entity_id')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->foreignId('user_id');
            $table->string('provider');
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('UAH');
            $table->unsignedInteger('ccy')->default(980);
            $table->string('status')->index()->default('created');;
            $table->json('payload')->nullable(); // зберігаємо все що приходить
            $table->json('order')->nullable(); // зберігаємо все що приходить
            $table->morphs('payable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
