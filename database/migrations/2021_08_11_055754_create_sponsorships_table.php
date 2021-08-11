<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('child_id')->unsigned()->index();
            $table->bigInteger('sponsor_id')->unsigned()->index();
            $table->boolean('monthly')->default(false);
            $table->double('amount');
            $table->timestamps();

            $table->foreign('child_id')->references('id')->on('children')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('sponsor_id')->references('id')->on('sponsors')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponsorships');
    }
}
