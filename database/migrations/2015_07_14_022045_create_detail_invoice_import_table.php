<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailInvoiceImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_invoice_import', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('color_id');
            $table->integer('size_id');
            $table->integer('number');
            $table->integer('price_import');
            $table->integer('invoice_import_id');
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
        Schema::drop('detail_invoice_import');
    }
}
