<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gigads', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 64);
            $table->bigInteger('gig_category_id')->unsigned();
            $table->boolean('is_public')->default(false);
            $table->integer('organization_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['uid']);
            $table->foreign('organization_id')->references('id')
                ->on('organizations')->onDelete('cascade');
            $table->foreign('gig_category_id')->references('id')
                ->on('gig_categories')->onDelete('cascade');
        });

        Schema::create('gigad_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('gigad_id')->unsigned();
            $table->string('link', 255)->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->char('locale', 2)->index();
            $table->boolean('auto_translated')->default(false)->comment('If true, indicates this translation was made by a machine');

            $table->unique(['gigad_id', 'locale']);
            $table->foreign('gigad_id')->references('id')->on('gigads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gigad_translations');
        Schema::dropIfExists('gigads');
    }
}
