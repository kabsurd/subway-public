<?php

use Illuminate\Database\Seeder;

class SauceSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table( 'sauces' )->insert( [
			[
				'key'   => 'sauce_1',
				'value' => 'Mayonaise',
			],
			[
				'key'   => 'sauce_2',
				'value' => 'Ketchup',
			],
			[
				'key'   => 'sauce_3',
				'value' => 'Joppiesaus',
			]
		] );
	}
}
