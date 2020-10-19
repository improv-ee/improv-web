<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gig_categories', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gig_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('gig_category_id')->unsigned();
            $table->string('name', 255);
            $table->text('description')->nullable()->default(null);
            $table->char('locale', 2)->index();
            $table->boolean('auto_translated')->default(false)->comment('If true, indicates this translation was made by a machine');
            $table->unique(['gig_category_id', 'locale']);
            $table->foreign('gig_category_id')->references('id')->on('gig_categories')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gig_categories');
        Schema::dropIfExists('gig_category_translations');
    }
}
