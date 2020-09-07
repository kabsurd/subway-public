<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'orders', function ( Blueprint $table ) {
			$table->id();
			$table->bigInteger( 'user_id' )->unsigned();
			$table->bigInteger( 'meal_id' )->unsigned();
			$table->enum( 'bread', [ 'bread_1', 'bread_2', 'bread_3' ] );
			$table->enum( 'length', [ '15cm', '30cm' ] );
			$table->boolean( 'oven_baked' )->default( false );
			$table->enum( 'taste', [ 'taste_1', 'taste_2', 'taste_3' ] );
			$table->enum( 'sauce', [ 'sauce_1', 'sauce_2', 'sauce_3' ] );
			$table->boolean( 'extra_bacon' )->default( false );
			$table->boolean( 'double_meat' )->default( false );
			$table->boolean( 'extra_cheese' )->default( false );
			$table->timestamps();

			$table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
			$table->foreign( 'meal_id' )->references( 'id' )->on( 'meals' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'orders' );
	}
}
