<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductConditions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_conditions', function(Blueprint $table)
		{
			$table->dropColumn('condition');
            $table->tinyInteger('highlights');
            $table->tinyInteger('notes');
            $table->tinyInteger('num_damaged_pages');
            $table->tinyInteger('broken_spine');
            $table->tinyInteger('broken_binding');
            $table->tinyInteger('water_damage');
            $table->tinyInteger('stains');
            $table->tinyInteger('burns');
            $table->tinyInteger('rips');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_conditions', function(Blueprint $table)
		{
		});
	}

}
