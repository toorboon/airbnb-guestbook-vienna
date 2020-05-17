<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeyForFellowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fellows', function (Blueprint $table) {
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fellows', function (Blueprint $table) {
            $table->dropForeign('fellows_guest_id_foreign');
        });
    }
}
