<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('departure');
            $table->string('menu_type');
            $table->string('lot_number');
            $table->string('title');
            $table->integer('print_quantity');
            $table->integer('packs');
            $table->string('flight_number');
            $table->string('arrival');
            $table->string('shipper');
            $table->integer('allocated');
            $table->unsignedBigInteger('job_id');
            $table->foreign('job_id')
                ->references('id')
                ->on('jobs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights', function (Blueprint $table) {
            $table->dropForeign('job_id');
        });
    }
};
