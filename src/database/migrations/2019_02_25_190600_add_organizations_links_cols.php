<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrganizationsLinksCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('email', 255)
                ->nullable()
                ->default(null);

            $table->string('homepage_url', 255)
                ->nullable()
                ->default(null);

            $table->string('facebook_url', 255)
                ->nullable()
                ->default(null);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Need to drop columns in separate Schema::table operation
        // to facilitate unit testing with sqlite db backend, which requires this
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('email');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('homepage_url');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('facebook_url');
        });
    }
}
