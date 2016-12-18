<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_category_id')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('parent_category_id')->references('id')->on('categories');
        });

        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('state_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');
        });



        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->integer('city_id')->nullable()->unsigned();
            $table->integer('category_id')->nullable()->unsigned();
            $table->double('lat');
            $table->double('lng');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('paytm_id');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('category_id')->references('id')->on('categories');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shops');
        Schema::drop('cities');
        Schema::drop('states');
        Schema::drop('categories');
    }
}
