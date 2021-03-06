<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrimaryKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('treatments', function (Blueprint $table) {
            //
            DB::statement("ALTER TABLE `dentus`.`treatments` CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT ;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('treatments', function (Blueprint $table) {
            //
        });
    }
}
