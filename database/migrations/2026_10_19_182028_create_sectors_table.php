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
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->json('slug');
            $table->json('name');
            $table->json('summary');
            $table->string('icon');
            $table->string('image')->nullable();
            $table->decimal('figure_value', 14, 2)->nullable();
            $table->unsignedTinyInteger('figure_decimals')->default(0);
            $table->string('figure_prefix')->nullable();
            $table->json('figure_suffix')->nullable();
            $table->json('figure_label')->nullable();
            $table->string('figure_source')->nullable();
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectors');
    }
};
