<?php

use Illuminate\Database\Seeder;

class FlavourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table( 'flavours' )->insert( [
		    [
			    'key'   => 'taste_1',
			    'value' => 'Kip kerrie',
		    ],
		    [
			    'key'   => 'taste_2',
			    'value' => 'Tropical salsa',
		    ],
		    [
			    'key'   => 'taste_3',
			    'value' => 'Surinaamse ei',
		    ]
	    ] );
    }
}
