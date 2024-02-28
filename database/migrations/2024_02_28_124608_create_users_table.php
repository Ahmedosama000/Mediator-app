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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('gender')->comment('0-> male / 1-> female');
            $table->tinyInteger('status')->default(0)->comment('0-> not active / 1-> active / 2-> blocked');
            $table->smallInteger('phone')->unique();
            $table->date('DOB');
            $table->string('photo')->default('default.png');
            $table->string('github')->nullable();
            $table->string('facebook')->nullable();
            $table->string('bio')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('university_id')->references('id')->on('universities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('salary_id')->references('id')->on('salaries')->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
