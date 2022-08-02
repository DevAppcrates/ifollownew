<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberOfUsersCcColumnAdminsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('admins', function (Blueprint $table) {
			$table->integer('allow_no_of_users_in_cc')->default(0)->after('number_of_admin_centers');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('admins', function (Blueprint $table) {
			$table->dropColumn('allow_no_of_users_in_cc');
		});
	}
}
