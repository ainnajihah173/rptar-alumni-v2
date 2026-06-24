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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); // Reference to the users table
            $table->foreignId('assign_id')->nullable();
            $table->enum('category', ['general', 'complaint', 'others']); // Example categories
            $table->string('title');
            $table->string('image_path')->nullable();
            $table->text('description');
            $table->date('resolved_date')->nullable();
            $table->text('solution')->nullable();
            $table->enum('status', ['Pending', 'In Progress', 'Resolved'])->default('Pending');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
