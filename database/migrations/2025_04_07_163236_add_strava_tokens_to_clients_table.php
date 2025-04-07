<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStravaTokensToClientsTable extends Migration
{
    public function up()
    {
        Schema::table('client', function (Blueprint $table) {
            if (!Schema::hasColumn('client', 'strava_access_token')) {
                $table->string('strava_access_token')->nullable();
            }
            if (!Schema::hasColumn('client', 'strava_refresh_token')) {
                $table->string('strava_refresh_token')->nullable();
            }
            if (!Schema::hasColumn('client', 'strava_token_expires_at')) {
                $table->dateTime('strava_token_expires_at')->nullable(); // Use datetime instead of timestamp
            }
        });
    }

    public function down()
    {
        Schema::table('client', function (Blueprint $table) {
            $table->dropColumn([
                'strava_access_token',
                'strava_refresh_token',
                'strava_token_expires_at'
            ]);
        });
    }
}