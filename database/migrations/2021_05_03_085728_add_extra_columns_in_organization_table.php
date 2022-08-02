<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsInOrganizationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('organizations', function (Blueprint $table) {
			$table->string('business_name')->nullable()->after('additional_fields');
			$table->string('business_type')->nullable()->after('business_name');
			$table->string('last_name')->nullable()->after('name');
			$table->string('title')->nullable()->after('last_name');

			$table->string('other_phone')->nullable()->after('title');
			$table->string('website')->nullable()->after('other_phone');
			$table->string('mailing_st')->nullable()->after('website');
			$table->string('mailing_city')->nullable()->after('mailing_st');
			$table->string('mailing_state')->nullable()->after('mailing_city');
			$table->string('mailing_zip_code')->nullable()->after('mailing_state');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('organizations', function (Blueprint $table) {
			$table->dropColumn(['business_name', 'business_type', 'last_name', 'title', 'other_phone', 'website', 'mailing_st', 'mailing_city', 'mailing_state', 'mailing_zip_code']);
		});
	}
}
