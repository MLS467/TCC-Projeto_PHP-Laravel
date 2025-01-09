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
        Schema::table('patients', function (Blueprint $table) {
            $table->integer('bleeding')->default(0);
            $table->integer('difficulty_breathing')->default(0);
            $table->integer('edema')->default(0);
            $table->integer('nausea')->default(0);
            $table->integer('vomiting')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['bleeding', 'difficulty_breathing', 'edema', 'nausea', 'vomiting']);
        });
    }
};