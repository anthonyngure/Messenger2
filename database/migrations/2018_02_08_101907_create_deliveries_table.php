<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateDeliveriesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('deliveries', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('client_id', false);
				$table->foreign('client_id')->references('id')->on('users');
				$table->string('origin_name');
				$table->string('origin_vicinity');
				$table->string('origin_formatted_address');
				$table->double('origin_latitude', 8, 5);
				$table->double('origin_longitude', 8, 5);
				$table->date('schedule_date');
				$table->time('schedule_time');
				$table->double('estimated_cost', 8, 2);
				$table->double('estimated_max_distance', 8, 2);
				$table->double('estimated_max_duration', 8, 2);
				$table->double('actual_cost', 8, 2)->default(0);
				$table->timestamps();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema::dropIfExists('deliveries');
		}
	}
