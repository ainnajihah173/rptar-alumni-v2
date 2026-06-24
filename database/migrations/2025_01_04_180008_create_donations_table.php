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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->nullable(); // Campaign reference
            $table->foreignId('user_id')->nullable(); // User reference
            $table->decimal('amount', 10, 2); // Donation amount
            $table->string('payment_method')->nullable();
            $table->boolean('is_anonymous')->default(false); // Anonymous donation flag
            $table->string('receipt_number')->nullable(); // For receipts/invoices
            $table->enum('payment_status', ['pending', 'successful', 'failed'])->nullable();
            $table->string('bill_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
