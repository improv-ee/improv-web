<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid', 64);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->boolean('is_public')->default(false);
            $table->integer('production_id')->unsigned();
            $table->integer('creator_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('production_id')
                ->references('id')
                ->on('productions')
                ->onDelete('cascade');

            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->unique(['uid']);
        });


        Schema::create('event_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->string('title')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->char('locale', 2)->index();

            $table->unique(['event_id', 'locale']);
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_translations');
        Schema::dropIfExists('events');
    }
}
