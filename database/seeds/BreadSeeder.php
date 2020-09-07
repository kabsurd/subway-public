<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreadSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table( 'breads' )->insert( [
			[
				'key'   => 'bread_1',
				'value' => 'Bruin brood',
			],
			[
				'key'   => 'bread_2',
				'value' => 'Wit brood',
			],
			[
				'key'   => 'bread_3',
				'value' => 'Spelt brood',
			]
		] );
	}
}
