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
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::table('practice', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
