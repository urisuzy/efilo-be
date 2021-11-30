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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('room_id')->nullable();
            $table->string('birthday')->nullable();
            $table->char('phone_number', 14)->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->text('parents_number')->nullable();
            $table->string('institution')->nullable();
            $table->char('number_plate')->nullable();
            $table->string('vehicle')->nullable();
            $table->string('id_card')->nullable();
            $table->string('family_card')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('out_date')->nullable();
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
