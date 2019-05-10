<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNumberSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->integer('length')->unsigned()->default(10);
            $table->integer('increment_by')->unsigned()->default(1);
            $table->string('padding_character')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('starting_number')->unsigned()->default(0);
            $table->integer('ending_number')->unsigned();
            $table->integer('last_used_number')->unsigned()->default(0);

            $table->unique(['prefix', 'padding_character', 'suffix']);

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
        Schema::dropIfExists('number_series');
    }
}
