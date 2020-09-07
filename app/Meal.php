<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Meal extends Model {
	const STATUS_OPEN = 'open';
	const STATUS_CLOSED = 'closed';

	protected $fillable = [
		'name',
		'detail'
	];

	private $status;

	/**
	 *  Get all the orders of a meal belonging to logged in user
	 */
	public function myOrders() {
		return $this->hasMany( Order::class )->where( 'user_id', Auth::id() );
	}

	/**
	 *  Get all the orders of a meal
	 */
	public function orders() {
		return $this->hasMany( Order::class );
	}
}
