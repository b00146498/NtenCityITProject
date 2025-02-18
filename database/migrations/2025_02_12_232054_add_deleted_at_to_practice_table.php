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
            if (!Schema::hasColumn('practice', 'deleted_at')) { // ✅ Check if column exists
                $table->softDeletes(); // Adds 'deleted_at' column for soft deletes
            }
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
            if (Schema::hasColumn('practice', 'deleted_at')) { // ✅ Only drop if it exists
                $table->dropColumn('deleted_at');
            }
        });
    }
}

