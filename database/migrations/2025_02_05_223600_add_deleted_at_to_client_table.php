<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client', function (Blueprint $table) {
            $table->softDeletes(); // This adds the 'deleted_at' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client', function (Blueprint $table) {
            $table->dropColumn('deleted_at'); // This removes the column if rolled back
        });
    }
}
