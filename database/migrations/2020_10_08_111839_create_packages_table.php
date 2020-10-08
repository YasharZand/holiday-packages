<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name',70);
            $table->string('hotel_name',50);
            $table->string('hotel_url',113);
            $table->tinyInteger('hotel_star')->default(1);
            $table->tinyInteger('duration')->default(1);
            $table->date('package_start_date');
            $table->tinyInteger('validity');            
            $table->decimal('price', 8, 2);
            $table->integer('quantity')->default(-1)->nullable();
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
        Schema::dropIfExists('packages');
    }
}
