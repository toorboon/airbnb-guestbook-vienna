<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->Integer('accommodation_id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('gender');
            $table->date('birth_date');
            $table->string('citizenship');
            $table->string('document_type');
            $table->string('document');
            $table->string('address');
            $table->dateTime('arrival_date');
            $table->dateTime('est_departure_date');
            $table->dateTime('act_departure_date')->nullable();
            $table->text('signature')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('guests');
    }
}
