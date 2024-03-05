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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('classification');
            $table->string('faculty');
            $table->year('year');
            $table->enum('status',['accepted','rejected','under_processing']);
            $table->string('assistant_teacher_name');
            $table->string('assistant_teacher_email')->unique();
            $table->string('professor_name');
            $table->string('professor_email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_projects');
    }
};
