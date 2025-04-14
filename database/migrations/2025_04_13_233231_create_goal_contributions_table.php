<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goal_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('savings_goals')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('source')->nullable(); // e.g., savings account, M-Pesa, etc.
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_contributions');
    }
};

