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
        Schema::create('recipes', function (Blueprint $table) {

            
            $table->id('recipe_id');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('image_path')->nullable();

            $table->string('title');

            $table->text('description');

            $table->enum('category',['Breakfast', 'Lunch' , 'Dinner', 'Dessert', 'Snack']);

            $table->integer('prep_time')->nullable();

            $table->boolean('is_public')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
