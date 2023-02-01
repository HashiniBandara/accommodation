<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('profile_pic')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger('is_super_admin')->default('0')->comment = 'if is_super_admin = 1 no system permissions checked';
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
        Schema::dropIfExists('users');
    }
}
