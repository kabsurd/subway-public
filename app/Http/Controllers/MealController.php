<?php

namespace App\Http\Controllers;

use App\Meal;
use App\Order;
use App\User;
use App\Vegetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller {
	private $status;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$meals = Meal::latest()->paginate( 5 );

		return view( 'meals.index', compact( 'meals' ) )
			->with( 'i', ( request()->input( 'page', 1 ) - 1 ) * 5 )->with( 'isAdmin', $this->isAdmin() );
	}

	/**
	 * Function to help determine if user is an Admin
	 *
	 * @return bool
	 */
	private function isAdmin() {
		$isAdmin = false;
		$user    = User::find( Auth::id() );
		if ( $user ) {
			$isAdmin = $user->admin;
		}

		return $isAdmin;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Meal $meal
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( Meal $meal ) {
		return view( 'meals.show', compact( 'meal' ) )->with( 'isAdmin', $this->isAdmin() );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Meal $meal
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Meal $meal ) {
		$meal->delete();

		return redirect()->route( 'meals.index' )
		                 ->with( 'success', 'Meal deleted successfully' );
	}

	/**
	 * Adding an order to a meal
	 *
	 * @param Request $request
	 * @param $meal_id
	 *
	 * @return $this
	 */
	public function addOrder( Request $request, $meal_id ) {
		$data            = $request->all();
		$data['user_id'] = Auth::id();
		$meal            = Meal::find( $meal_id );
		$order           = new Order( $data );
		$meal->orders()->save( $order );

		$vegetable           = new Vegetable();
		$vegetable           = $this->updateVegetables( $vegetable, $data['vegetable'] );
		$vegetable->order_id = $order->id;
		$order->vegetables()->save( $vegetable );

		return redirect()->route( 'meals.index' )
		                 ->with( 'success', 'Order created successfully' );
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
	 * Adding an order to a meal
	 *
	 * @return $this
	 */
	public function addMeal() {
		if ( $this->isAdmin() ) {
			$meal = new Meal();
			$meal->save();

			return redirect()->route( 'meals.index' )
			                 ->with( 'success', 'Meal created successfully' );
		}

		return redirect()->route( 'meals.index' )
		                 ->with( 'error', 'Meal has not been created!' );
	}

	/**
	 * Settings the status of a meal
	 *
	 * @param $meal_id
	 *
	 * @return $this
	 */
	public function changeStatus( $meal_id ) {
		if ( ! $this->isAdmin() ) {
			return redirect()->route( 'meals.index' )
			                 ->with( 'error', 'Meal status could not be changed.' );
		}
		$meal = Meal::find( $meal_id );

		if ( $meal->status == Meal::STATUS_OPEN ) {
			$meal->status = Meal::STATUS_CLOSED;
		} elseif ( $meal->status == Meal::STATUS_CLOSED ) {
			if ( Meal::where( 'status', 'open' )->count() < 1 ) {
				$meal->status = Meal::STATUS_OPEN;
			} else {
				return redirect()->route( 'meals.index' )
				                 ->with( 'error', 'Meal status could not be changed. Only one meal can be open at the same time!' );
			}
		}

		$meal->update();

		return redirect()->route( 'meals.index' )
		                 ->with( 'success', 'Meal status changed.' );
	}

	/**
	 * Show order overview of the specified meal
	 *
	 * @param $meal_id
	 *
	 * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showOrderOverview( $meal_id ) {
		$meal = Meal::find( $meal_id );
		if ( $meal instanceof Meal ) {
			if ( $meal->status == Meal::STATUS_CLOSED ) {
				return view( 'meals.overview', compact( 'meal' ) );
			} else {
				return redirect()->to( '/meals/' . $meal_id )
				                 ->with( 'error', 'Meal status is not closed yet!' );
			}
		}

		return redirect()->to( '/meals/' )
		                 ->with( 'error', 'Something went wrong' );
	}

}
