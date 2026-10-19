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
        Schema::create('programme_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edition_id')->constrained()->cascadeOnDelete();
            $table->date('day');
            $table->time('starts_at')->nullable();
            $table->time('ends_at')->nullable();
            $table->json('title');
            $table->string('kind');
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();

            $table->index(['edition_id', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programme_sessions');
    }
};
