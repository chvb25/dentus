<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToReceivable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivable', function($table) {
            $table->float('debt');
            $table->date('first_date');
            $table->char('periodicity', 1)->default('m');
            $table->smallInteger('quotas')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivable', function($table) {
            $table->dropColumn('debt');
            $table->dropColumn('first_date');
            $table->dropColumn('periodicity', 1);
            $table->dropColumn('quotas');
        });
    }
}
