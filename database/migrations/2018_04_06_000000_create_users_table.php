<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_octo_users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('avatar', 600)->default('/img/user-no-logo.png');

            $table->string('display_name', 150)->nullable();
            $table->string('first_name', 150)->nullable();
            $table->string('middle_name', 150)->nullable();
            $table->string('last_name', 150)->nullable();

            $table->string('password');

            $table->string('email', 150)->unique();

            $table->string('status', 20)->default('not_confirmed');

            $table->integer('organisation_id')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->smallInteger('login_attempts')->default(0);

            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tbl_octo_users');
    }
}
