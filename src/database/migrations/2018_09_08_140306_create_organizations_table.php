<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_public')->default(false);
            $table->integer('creator_id')->unsigned();
            $table->integer('header_img_id')->unsigned()->nullable()->default(null);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('header_img_id')
                ->references('id')
                ->on('images')
                ->onDelete('cascade');
        });

        Schema::create('organization_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned();
            $table->string('name');
            $table->text('description')->nullable()->default(null);
            $table->string('slug');
            $table->char('locale', 2)->index();

            $table->unique(['name', 'locale']);
            $table->unique(['slug', 'locale']);
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_translations');
        Schema::dropIfExists('organizations');
    }
}
