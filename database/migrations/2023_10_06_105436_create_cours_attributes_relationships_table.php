<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursAttributesRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cours_attributes_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Course::class);
            $table->foreignIdFor(\App\Models\Attribute::class);
            $table->foreignIdFor(\App\Models\CourseCategory::class);
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
        Schema::dropIfExists('cours_attributes_relationships');
    }
}
