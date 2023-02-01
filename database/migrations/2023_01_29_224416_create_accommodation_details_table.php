<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_details', function (Blueprint $table) {
            $table->id();
            $table->integer('accommodation_type_id');
            $table->string('title');
            $table->string('banner');
            $table->string('description');
            $table->string('gallery');
            $table->tinyInteger('status')->default(STATUS_ACTIVE)->comment = STATUS_ACTIVE . ' = active , ' . STATUS_INACTIVE . ' = disabled';
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
        Schema::dropIfExists('accommodation_details');
    }
};
