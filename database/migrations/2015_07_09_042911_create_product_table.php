<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key_product')->unique();
            $table->string('name_product');
            $table->integer('status');
            $table->bigInteger('price_import');
            $table->bigInteger('price');
            $table->bigInteger('cost');
            $table->string('image');
            $table->text('information');
            $table->string('category_id');
            $table->integer('selloff_id');
            $table->integer('style_id');
            $table->integer('madein_id');
            $table->integer('material_id');
            $table->integer('height_id');
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
        Schema::drop('sanpham');
    }
}
