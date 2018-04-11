<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 4/11/2018
 * Time: 17:55
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_octo_organizations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 150)->unique();
            $table->string('route_name', 150)->unique();

            $table->unsignedInteger('leader_id');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('leader_id')
                ->references('id')->on('tbl_octo_users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tbl_octo_organizations');
    }
}