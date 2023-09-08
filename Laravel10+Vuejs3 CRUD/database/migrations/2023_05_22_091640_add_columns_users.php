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
        $table->string('profile_image')->nullable()->default(null);
        $table->string('phone')->nullable()->default(null);
        $table->text('location')->nullable()->default(null);
        $table->string('education_level')->nullable()->default(null);
        $table->integer('gender')->nullable()->default(null);
        $table->string('languages')->nullable()->default(null);
        $table->string('dob')->nullable()->default(null);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
