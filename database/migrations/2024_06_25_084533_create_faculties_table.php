<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('alanguage');
            $table->string('title');
            $table->text('slug');
            $table->string('image');
            $table->integer('order');
            $table->tinyInteger('publish');
            $table->tinyInteger('ishome');
            $table->tinyInteger('highlight');
            $table->tinyInteger('isaside');
            $table->tinyInteger('isfooter');
            $table->text('description')->nullable();
            $table->string('truong_khoa')->nullable();
            $table->string('nhan_luc')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
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
        Schema::dropIfExists('faculties');
    }
}
