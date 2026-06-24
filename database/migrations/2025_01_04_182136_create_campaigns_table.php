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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by'); // Created by (id)
            $table->string('title');
            $table->string('image_path')->nullable(); // For campaign images
            $table->text('description')->nullable();
            $table->decimal('target_amount', 10, 2)->default(0.00); // Campaign goal
            $table->decimal('current_amount', 10, 2)->default(0.00); // Funds raised
            $table->date('start_date');
            $table->date('end_date')->nullable(); // If the campaign has an expiry
            $table->enum('status', ['active', 'closed', 'pending', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
