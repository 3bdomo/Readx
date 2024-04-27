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
        Schema::create('research', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('researcher_name');
            $table->string('researcher_email')->nullable();
            $table->string('publishing_year');
            $table->string('field');
            $table->string('description');
            $table->string('status')->nullable();
            $table->string('the_supervisory_authority');
            $table->string('faculty')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research');
    }
};
