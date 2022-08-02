<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefferencedSubAdminAdmins extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('admins', function (Blueprint $table) {
			$table->string('refferenced_sub_admin')->nullable()->after('user_type')->default('command center')->comment = 'admin or command center';
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('admins', function (Blueprint $table) {
			$table->dropColumn('refferenced_sub_admin');
		});
	}
}
