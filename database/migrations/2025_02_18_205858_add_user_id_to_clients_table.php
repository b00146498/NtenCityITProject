<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'user_id')) { // ✅ Check if 'user_id' exists before adding
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'user_id')) { // ✅ Check if 'user_id' exists before dropping
                $table->dropColumn('user_id');
            }
        });
    }

}
