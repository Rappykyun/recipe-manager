<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipe_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('recipe_id');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->primary(['recipe_id', 'tag_id']);
            $table->timestamps();

            $table->foreign('recipe_id')->references('recipe_id')->on('recipes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_tag');
    }
};
