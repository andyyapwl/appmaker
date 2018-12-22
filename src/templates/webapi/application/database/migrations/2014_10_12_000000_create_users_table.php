<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
			$table->string('username');
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('portal_account_id')->nullable();
			$table->string('portal_id')->nullable();
			$table->boolean('is_admin');
			$table->unsignedInteger('status_id');
			$table->foreign('status_id')->references('id')->on('account_statuses');
            $table->rememberToken();
           	$table->unsignedInteger('created_by')->nullable();
			$table->unsignedInteger('modified_by')->nullable();
            $table->timestamps();
			$table->boolean('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
