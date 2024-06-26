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
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('student_id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('faculty')->default('FCI-Minia');
            $table->boolean('eligible_to_registration')->default(false);
            $table->boolean('registration_status')->default(false);
            $table->enum('department',['CS','IS','BIO','general'])->required();
            $table->enum('grade',['1','2','3','4'])->required();
            $table->unsignedInteger('app_level')->default(0);
            $table->unsignedInteger('points')->default(0);
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
