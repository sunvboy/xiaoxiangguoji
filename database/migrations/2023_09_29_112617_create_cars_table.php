<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('alanguage');
            $table->string('title');
            $table->text('slug');
            $table->string('price');
            $table->string('code');
            $table->text('image_json');
            $table->string('image');
            $table->text('catalogue');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->integer('order');
            $table->tinyInteger('publish');
            $table->tinyInteger('ishome');
            $table->tinyInteger('highlight');
            $table->tinyInteger('isaside');
            $table->tinyInteger('isfooter');
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->foreignIdFor(\App\Models\CarsCategory::class);
            $table->foreignIdFor(\App\Models\User::class);
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
        Schema::dropIfExists('cars');
    }
}
