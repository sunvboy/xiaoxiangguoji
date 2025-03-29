<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('date_start');
            $table->string('date_end');
            $table->integer('adults');
            $table->integer('children');
            $table->integer('infants');
            $table->string('room');
            $table->string('note');
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
        Schema::dropIfExists('room_books');
    }
}
