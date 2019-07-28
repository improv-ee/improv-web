<?php

use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->bigIncrements('id');

            // https://stackoverflow.com/questions/24430241/google-places-api-place-id-field-length
            $table->string('uid', 255)->comment('Google Maps Places uid');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['uid']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->bigInteger('place_id')->unsigned()->nullable()->after('creator_id');

            $table->foreign('place_id')
                ->references('id')
                ->on('places')
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
        Schema::table('events', function (Blueprint $table) {

            // SQLite does not support dropping FK-s
            if (!DB::connection() instanceof SQLiteConnection) {
                $table->dropForeign('events_place_id_foreign');
            }

            $table->dropColumn('place_id');

        });

        Schema::dropIfExists('places');
    }
}
