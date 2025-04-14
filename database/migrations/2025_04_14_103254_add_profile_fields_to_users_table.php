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
        Schema::table('users', function (Blueprint $table) {
            // Add National ID field
            $table->string('national_id')->nullable()->after('email');

            // Add Income Range field
            $table->string('income_range')->nullable()->after('national_id');

            // Add Occupation field
            $table->string('occupation')->nullable()->after('income_range');

            // Add profile_completed field to track completion status
            $table->boolean('profile_completed')->default(false)->after('occupation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove added columns when rolling back
            $table->dropColumn([
                'national_id',
                'income_range',
                'occupation',
                'profile_completed'
            ]);
        });
    }
};
