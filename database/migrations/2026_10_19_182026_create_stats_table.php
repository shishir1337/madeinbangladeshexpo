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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->decimal('value', 14, 2);
            $table->unsignedTinyInteger('decimals')->default(0);
            $table->string('prefix')->nullable();
            $table->json('suffix')->nullable();
            $table->json('label');
            $table->string('source');
            $table->string('as_of');
            $table->string('placement')->default('home')->index();
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
