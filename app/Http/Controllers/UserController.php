<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$users = User::latest()->paginate( 5 );

		return view( 'users.index', compact( 'users' ) )
			->with( 'i', ( request()->input( 'page', 1 ) - 1 ) * 5 );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'users.create' );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\User $user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( User $user ) {
		return view( 'users.edit', compact( 'user' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\User $user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, User $user ) {
		$request->validate( [
			'name' => 'required',
		] );

		$user->update( $request->all() );

		return redirect()->route( 'users.index' )
		                 ->with( 'success', 'User updated successfully' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$request->validate( [
			'name' => 'required',
		] );

		$authCode = $this->generateAuthCode();

		$data              = $request->all();
		$data['email']     = 'user-' . $authCode . '@subsub.nl';
		$data['password']  = 'nologin';
		$data['auth_code'] = $authCode;

		User::create( $data );

		return redirect()->route( 'users.index' )
		                 ->with( 'success', 'Meal created successfully.' );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User $user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( User $user ) {
		$user->delete();

		return redirect()->route( 'users.index' )
		                 ->with( 'success', 'Order deleted successfully' );
	}

	/**
	 * Functio to generate an authentication code
	 *
	 * @return string
	 */
	private function generateAuthCode() {
		do {
			$authCode = Str::random( 5 );
		} while ( User::where( 'auth_code', $authCode )->first() instanceof User );

		return $authCode;
	}

	/**
	 * Function to login by authentication code.
	 *
	 * @param $authCode
	 *
	 * @return $this
	 */
	public function loginByCode( $authCode ) {
		if ( $authCode !== null ) {
			$user = User::where( 'auth_code', $authCode )->first();
			if ( $user instanceof User ) {
				Auth::login( $user );

				return redirect()->route( 'meals.index' )
				                 ->with( 'success', 'Logged in successfully.' );
			} else {
				Auth::logout( Auth::id() );

				return redirect()->route( 'meals.index' )
				                 ->with( 'error', 'This code does not match a user. You are not logged in!' );
			}
		}
	}
}
