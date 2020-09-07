<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

	protected $fillable = [
		'bread',
		'length',
		'oven_baked',
		'extra_cheese',
		'extra_bacon',
		'double_meat',
		'taste',
		'sauce',
		'user_id',
	];

	/*
	 * Get the connected meal
	 */
	public function meal() {
		return $this->belongsTo( Meal::class );
	}

	/*
	 * Get the connected user
	 */
	public function user() {
		return $this->belongsTo( User::class );
	}

	/*
	 * Get the connected vegetables
	 */
	public function vegetables() {
		return $this->hasOne( Vegetable::class );
	}

}
