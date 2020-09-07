<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		$this->call( UserSeeder::class );
		$this->call( BreadSeeder::class );
		$this->call( BreadLengthSeeder::class );
		$this->call( SauceSeeder::class );
		$this->call( FlavourSeeder::class );
	}
}
