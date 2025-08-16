<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bond_prices', function (Blueprint $table) {
            $table->id();
            $table->date('trade_date')->nullable()->index();
            $table->string('symbol', 100)->nullable()->index();
            $table->string('security_name', 255)->nullable();

            $table->decimal('open', 18, 4)->nullable();
            $table->decimal('high', 18, 4)->nullable();
            $table->decimal('low', 18, 4)->nullable();
            $table->decimal('close', 18, 4)->nullable();
            $table->decimal('previous_close', 18, 4)->nullable();
            $table->decimal('change', 18, 4)->nullable();
            $table->decimal('change_pct', 9, 4)->nullable();
            $table->unsignedBigInteger('volume')->nullable();
            $table->decimal('value', 20, 4)->nullable();
            $table->unsignedInteger('deals')->nullable();
            $table->decimal('spread_pct', 10, 4)->nullable();


            $table->json('payload')->nullable();

            $table->timestamps();
            $table->unique(['trade_date', 'symbol']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bond_prices');
    }
};
