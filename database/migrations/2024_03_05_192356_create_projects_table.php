<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->string('field');
            $table->string('output')->nullable();
            $table->string('faculty')->default("FCI Minia");
            $table->year('year');
            $table->string('documentation_path')->nullable();
            $table->enum('status',['accepted','rejected','pending']);
            $table->string('technologies')->nullable();
            $table->string('assistant_teacher_name')->nullable();
            $table->string('assistant_teacher_email')->unique()->nullable();
            $table->string('professor_name')->nullable();
            $table->string('professor_email')->unique()->nullable();
            $table->string('teamMember1')->nullable();
            $table->string('teamMember2')->nullable();
            $table->string('teamMember3')->nullable();
            $table->string('teamMember4')->nullable();
            $table->string('teamMember5')->nullable();
            $table->string('teamMember6')->nullable();
            $table->string('teamMember7')->nullable();
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
