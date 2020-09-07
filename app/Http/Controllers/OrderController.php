<?php

namespace App\Http\Controllers;

use App\Order;
use App\Vegetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$orders = Order::where( 'user_id', Auth::id() )->latest()->paginate( 5 );

		return view( 'orders.index', compact( 'orders' ) )
			->with( 'i', ( request()->input( 'page', 1 ) - 1 ) * 5 );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Order $order
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( Order $order ) {
		return view( 'orders.show', compact( 'order' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Order $order
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Order $order ) {
		return view( 'orders.edit', compact( 'order' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Order $order
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Order $order ) {
		if ( $order->meal->status === 'open' ) {
			$data = $request->all();

			$vegetable = $this->updateVegetables( $order->vegetables, $data['vegetable'] );
			$order->vegetables()->save( $vegetable );

			$order->update( $this->prepareOrder( $request, $data ) );


			return redirect()->route( 'meals.index' )
			                 ->with( 'success', 'Order updated successfully' );
		} else {
			return redirect()->route( 'meals.index' )
			                 ->with( 'error', 'The meal status was closed! Order has not been edited!!' );
		}

	}

	/**
	 * We need this function so the order checkbox field are storing correctly in the database
	 *
	 * @param Request $request
	 * @param $data
	 *
	 * @return mixed
	 */
	private function prepareOrder( Request $request, $data ) {
		$data["oven_baked"]   = $request->has( 'oven_baked' );
		$data["extra_cheese"] = $request->has( 'extra_cheese' );
		$data["extra_bacon"]  = $request->has( 'extra_bacon' );
		$data["double_meat"]  = $request->has( 'double_meat' );

		return $data;
	}

	/**
	 * @param Vegetable $vegetable
	 * @param array $vegData
	 *
	 * @return Vegetable
	 */
	private function updateVegetables( Vegetable $vegetable, array $vegData ) {
		$vegOptions = $vegetable->prepareVegetable( $vegData );

		foreach ( $vegOptions as $vegItem => $vegValue ) {
			$vegetable->$vegItem = $vegValue;
		}

		return $vegetable;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Order $order
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Order $order ) {
		$meal_id = $order->meal_id;
		$order->delete();

		return redirect()->route( 'meals.show', [ $meal_id ] )
		                 ->with( 'success', 'Order deleted successfully' );
	}

}
