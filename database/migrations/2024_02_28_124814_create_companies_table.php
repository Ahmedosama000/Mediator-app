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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('device_name',30);
            $table->string('email',64)->unique();
            $table->string('password',64);
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0-> not active / 1-> active / 2-> blocked');
            $table->string('phone',14);
            $table->string('photo',64)->default('default.png');
            $table->string('website',128)->nullable();
            $table->string('socials',128)->nullable();
            $table->string('about')->nullable();
            $table->foreignId('service_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
