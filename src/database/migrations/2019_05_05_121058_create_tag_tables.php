<?php

use App\Orm\Tag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTables extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->json('name');
            $table->json('slug');
            $table->string('type')->nullable();
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned();
            $table->integer('taggable_id')->unsigned();
            $table->string('taggable_type');

            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });


        // Create default tags for Productions

        $tag = Tag::create(['name' => 'workshop', 'type' => 'production']);
        $tag->setTranslation('name', 'et', 'töötuba');
        $tag->setTranslation('name', 'en', 'workshop');
        $tag->save();

        $tag = Tag::create(['name' => 'festival', 'type' => 'production']);
        $tag->setTranslation('name', 'et', 'festival');
        $tag->setTranslation('name', 'en', 'festival');
        $tag->save();

        $tag = Tag::create(['name' => 'show', 'type' => 'production']);
        $tag->setTranslation('name', 'et', 'etendus');
        $tag->setTranslation('name', 'en', 'show');
        $tag->save();

        $tag = Tag::create(['name' => 'course', 'type' => 'production']);
        $tag->setTranslation('name', 'et', 'kursus');
        $tag->setTranslation('name', 'en', 'course');
        $tag->save();

        $tag = Tag::create(['name' => 'jam', 'type' => 'production']);
        $tag->setTranslation('name', 'et', 'avatud tund');
        $tag->setTranslation('name', 'en', 'jam');
        $tag->save();

        $tag = Tag::create(['name' => 'shortform', 'type' => 'production']);
        $tag->setTranslation('name', 'et', 'lühivorm');
        $tag->setTranslation('name', 'en', 'shortform');
        $tag->save();

        $tag = Tag::create(['name' => 'longform', 'type' => 'production']);
        $tag->setTranslation('name', 'et', 'pikkvorm');
        $tag->setTranslation('name', 'en', 'longform');
        $tag->save();

        $tag = Tag::create(['name' => 'contact improv', 'type' => 'production']);
        $tag->setTranslation('name', 'et', 'kontaktimpro');
        $tag->setTranslation('name', 'en', 'contact improv');
        $tag->save();
    }

    public function down()
    {
        Schema::drop('taggables');
        Schema::drop('tags');
    }
}
