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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('savings_account_id')->constrained();
    $table->string('reference_number')->unique();
    $table->decimal('amount', 15, 2);
    $table->enum('type', ['deposit', 'withdrawal', 'transfer', 'interest']);
    $table->enum('status', ['pending', 'completed', 'failed', 'reversed'])->default('pending');
    $table->foreignId('goal_id')->nullable()->constrained('savings_goals');
    $table->text('description')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
