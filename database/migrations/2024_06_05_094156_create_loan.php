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
        Schema::create('loan', function (Blueprint $table) {
            $table->increments('loanId');
            $table->double('borrowerid');
            $table->double('loanplanId');
            $table->double('loantypeId');
            $table->double('staffId');
            $table->decimal('amount');
            $table->decimal('costAmount');
            $table->decimal('interestAmount');
            $table->decimal('penaltyAmount');
            $table->decimal('totalAmount');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan');
    }
};
