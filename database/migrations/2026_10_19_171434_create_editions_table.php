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
        Schema::create('editions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('number');
            $table->json('name');
            $table->date('starts_on');
            $table->date('ends_on');
            $table->dateTime('opening_at')->nullable();
            $table->string('timezone')->default('America/Sao_Paulo');
            $table->string('status');
            $table->boolean('is_current')->default(false);

            // MySQL has no partial indexes: 1 for the current edition, NULL otherwise, so the unique index allows one current edition.
            $table->unsignedTinyInteger('current_marker')
                ->nullable()
                ->storedAs('if(is_current, 1, null)')
                ->unique('editions_single_current');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editions');
    }
};
