<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationProductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_production', function (Blueprint $table) {

            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')
                ->on('organizations')->onDelete('cascade');

            $table->integer('production_id')->unsigned();
            $table->foreign('production_id')->references('id')
                ->on('productions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_production');
    }
}
