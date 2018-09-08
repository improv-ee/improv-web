<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('header_img')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('production_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('production_id')->unsigned();
            $table->string('title');
            $table->text('description')->nullable()->default(null);
            $table->text('excerpt')->nullable()->default(null);
            $table->string('slug');
            $table->char('locale', 2)->index();

            $table->unique(['production_id', 'locale']);
            $table->foreign('production_id')->references('id')->on('productions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_translations');
        Schema::dropIfExists('productions');
    }
}
