<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVegetablesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'vegetables', function ( Blueprint $table ) {
			$table->id();
			$table->bigInteger( 'order_id' )->unsigned();
			$table->boolean( 'tomato' )->default( false );
			$table->boolean( 'onion' )->default( false );
			$table->boolean( 'lettuce' )->default( false );
			$table->boolean( 'paprika' )->default( false );
			$table->timestamps();

			$table->foreign( 'order_id' )->references( 'id' )->on( 'orders' )->onDelete( 'cascade' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'vegetables' );
	}
}
