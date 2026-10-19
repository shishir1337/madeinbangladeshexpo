<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MariaDB (and MySQL with explicit_defaults_for_timestamp off) gives the first NOT NULL timestamp column
 * ON UPDATE CURRENT_TIMESTAMP, which rewrote the consent time on every confirm or unsubscribe. An explicit
 * default removes that, so consented_at stays the moment consent was given.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('newsletter_subscriptions', function (Blueprint $table) {
            $table->timestamp('consented_at')->useCurrent()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newsletter_subscriptions', function (Blueprint $table) {
            $table->timestamp('consented_at')->change();
        });
    }
};
