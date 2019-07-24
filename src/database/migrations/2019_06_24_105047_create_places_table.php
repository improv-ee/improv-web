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
            $table->string('uid', 64);
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
