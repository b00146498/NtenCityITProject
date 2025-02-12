<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToPracticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice', function (Blueprint $table) {
            $table->softDeletes(); // Adds 'deleted_at' column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practice', function (Blueprint $table) {
            $table->dropColumn('deleted_at'); // Removes 'deleted_at' column on rollback
        });
    }
}
