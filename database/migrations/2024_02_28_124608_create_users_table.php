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
            $table->string('first_name',30);
            $table->string('last_name',30);
            $table->string('email',64)->unique();
            $table->string('password',128);
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('gender')->comment('0-> male / 1-> female');
            $table->tinyInteger('status')->default(0)->comment('0-> not active / 1-> active / 2-> blocked');
            $table->string('phone',14);
            $table->date('DOB');
            $table->string('photo',64)->default('default.png');
            $table->string('github',128)->nullable();
            $table->string('facebook',128)->nullable();
            $table->string('bio',128)->nullable();
            $table->unsignedBigInteger('university_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('salary_id');
            $table->foreign('university_id')->references('id')->on('universities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
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
