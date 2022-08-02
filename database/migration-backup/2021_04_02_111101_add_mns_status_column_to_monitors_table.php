<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMnsStatusColumnToMonitorsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('monitors', function (Blueprint $table) {
			$table->boolean('mns_status')->default(1)->after('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('monitors', function (Blueprint $table) {
			$table->dropColumn('mns_status');
		});
	}
}
