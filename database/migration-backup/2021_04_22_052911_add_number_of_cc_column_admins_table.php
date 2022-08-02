<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberOfCcColumnAdminsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('admins', function (Blueprint $table) {
			$table->integer('number_of_admin_centers')->default(0)->after('notes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('admins', function (Blueprint $table) {
			$table->dropColumn('number_of_admin_centers');
		});
	}
}
