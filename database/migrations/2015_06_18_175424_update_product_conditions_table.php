<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductConditionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_conditions', function(Blueprint $table)
		{
            $table->dropColumn(
                [
                    'highlights',
                    'notes',
                    'num_damaged_pages',
                    'broken_spine',
                    'broken_binding',
                    'water_damage',
                    'stains',
                    'burns',
                    'rips'
                ]);
		});

        Schema::table('product_conditions', function(Blueprint $table)
        {

            $table->boolean('broken_binding');
            $table->tinyInteger('general_condition'); // 0: Brand new, 1: Excellent, 2: Good, 3: Acceptable
            $table->tinyInteger('highlights_and_notes');
            $table->tinyInteger('damaged_pages');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}
