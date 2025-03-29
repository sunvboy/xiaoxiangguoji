<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionOptionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_option_users', function (Blueprint $table) {
            $table->id();
            $table->text('value');
            $table->foreignIdFor(\App\Models\Quiz::class);
            $table->foreignIdFor(\App\Models\Question::class);
            $table->foreignIdFor(\App\Models\QuestionOption::class);
            $table->foreignIdFor(\App\Models\Customer::class);
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
        Schema::dropIfExists('question_option_users');
    }
}
