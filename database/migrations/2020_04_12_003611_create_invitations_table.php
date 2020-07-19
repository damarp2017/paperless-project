<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requested_by_store');
            $table->unsignedBigInteger('to');
            $table->boolean('status')->nullable();
            $table->tinyInteger('role');
            $table->string('message')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('requested_by_store')->references('id')->on('stores');
            $table->foreign('to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
