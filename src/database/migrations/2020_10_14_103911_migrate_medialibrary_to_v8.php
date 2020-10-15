<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateMedialibraryToV8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('conversions_disk')->nullable();
            $table->uuid('uuid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 2 calls to support sqlite DB backend; can't do it in one go
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('conversions_disk');
        });
    }
}
