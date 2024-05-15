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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('author_name');
            $table->string('publisher')->nullable();
            $table->string('publishing_year')->nullable();
            $table->string('edition')->nullable();
            $table->string('category')->nullable();
            $table->string('ISBN')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->float('rating',8,2)->nullable();
            $table->enum('status',['available','unavailable'])->default('available');
            $table->string('faculty')->default("FCI-Minia");
            $table->integer('pages_number')->unsigned()->nullable();
            $table->integer('rates_number')->default(0);
            $table->timestamps();
        });

        if(env('APP_ENV')!='local'){
            \App\Models\Api\Book::factory(20)->create();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
