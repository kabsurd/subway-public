<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vegetable extends Model {
	public static function getOptions() {
		return [
			'tomato',
			'onion',
			'lettuce',
			'paprika',
		];
	}

	/*
	 * Get the connected order
	 */
	public function order() {
		return $this->belongsTo( Order::class );
	}

	public function prepareVegetable( $vegData ) {
		$options = $this->getOptions();
		$data    = [];
		foreach ( $options as $option ) {
			if ( in_array( $option, $vegData ) ) {
				$data[ $option ] = 1;
			} else {
				$data[ $option ] = 0;
			}
		}

		return $data;
	}
}
