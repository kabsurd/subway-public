<?php

use Illuminate\Database\Seeder;

class BreadLengthSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table( 'bread_lengths' )->insert( [
			[
				'key'   => '15cm',
				'value' => '15 centimeter',
			],
			[
				'key'   => '30cm',
				'value' => '30 centimeter',
			]
		] );
	}
}
