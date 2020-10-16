<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('invites');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Recreate dropped table on down migration; however this is data destructive
        Schema::create('invites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('for')->nullable()->unique();
            $table->integer('max')->default(1);
            $table->integer('uses')->default(0);
            $table->timestamp('valid_until')->nullable();
            $table->timestamps();
        });
    }
}
