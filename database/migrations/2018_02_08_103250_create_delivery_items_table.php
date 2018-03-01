<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateDeliveryItemsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('delivery_items', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('courier_option_id', false);
				$table->foreign('courier_option_id')->references('id')->on('courier_options');
				$table->unsignedInteger('delivery_id', false);
				$table->foreign('delivery_id')->references('id')->on('deliveries');
				$table->string('destination_name');
				$table->string('destination_vicinity');
				$table->string('destination_formatted_address');
				$table->double('destination_latitude', 8, 5);
				$table->double('destination_longitude', 8, 5);
				$table->string('recipient_name');
				$table->string('recipient_contact');
				$table->unsignedSmallInteger('quantity');
				$table->string('note')->nullable();
				$table->double('estimated_distance', 8, 2);
				$table->double('estimated_duration', 8, 2);
				$table->enum('status', ['AT_PICKUP', 'EN_ROUTE_TO_DESTINATION', 'AT_DESTINATION'])
					->default('AT_PICKUP');
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
			Schema::dropIfExists('delivery_items');
		}
	}
