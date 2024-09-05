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
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->String('image')->nullable();
            $table->string('place_of_birth');
            $table->date('dob');
            $table->text('full_address');
            $table->string('nationality');

            $table->string('gender');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('password');
            $table->string('membership_type');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
