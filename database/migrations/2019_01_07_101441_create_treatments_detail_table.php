<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreatmentsDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatments_detail', function (Blueprint $table) {
            $table->integer('id');
            $table->bigInteger('treatments_id');
            $table->integer('procedure_id');
            $table->smallInteger('status')->default(0);
            $table->float('price');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treatments_detail');
    }
}
