<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GridMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grids', function (Blueprint $table) {
            $table->increments('id');
            $table->double('lat');
            $table->double('lng');
            $table->boolean('processed')->default(0);
            $table->integer('priority')->default(1);
            $table->integer('store_count')->default(0);
            $table->timestamps();
        });

        Schema::create('grid_scan_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grid_id')->unsigned();
            $table->string('service')->default('paytm');
            $table->integer('store_count');
            $table->string('data_key');
            $table->timestamps();

            $table->foreign('grid_id')->references('id')->on('grids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grid_scan_logs');
        Schema::drop('grids');
    }
}
