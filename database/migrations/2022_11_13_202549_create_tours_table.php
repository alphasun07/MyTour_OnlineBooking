<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description');
            $table->integer('tour_time');
            $table->string('places');
            $table->float('price_per_person');
            $table->tinyInteger('status')->default(1);
            $table->Integer('max_person')->default(5);
            $table->string('thumbnail')->nullable();
            $table->string('images')->nullable();
            $table->integer('category_id');
            $table->tinyInteger('featured');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
