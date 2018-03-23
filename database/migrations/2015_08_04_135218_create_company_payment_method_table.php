<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyPaymentMethodTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('company_payment_method', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('payment_method_id');
            $table->tinyInteger('status');
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
        Schema::drop('company_payment_method');
	}

}
