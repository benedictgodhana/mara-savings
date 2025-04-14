<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsCompletedToSavingsGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('savings_goals', function (Blueprint $table) {
            $table->boolean('is_completed')->default(false); // Add this line
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('savings_goals', function (Blueprint $table) {
            $table->dropColumn('is_completed');
        });
    }
}
