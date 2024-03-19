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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('subject_name');
            $table->string('image_path');
            $table->integer('year')->nullable();
            $table->enum('type',['final','mid']);
            $table->string('professor_name')->nullable();
            $table->enum('grade',['First','Second','Third','Fourth']);
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }

};
