<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitorOrganizationsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('monitor_organizations', function (Blueprint $table) {
			$table->increments('id');
			$table->string('monitor_id')->nullable();
			$table->foreign('monitor_id')->references('monitor_id')->on('monitors')->onDelete('cascade');
			$table->string('organization_id')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('monitor_organizations');
	}
}
