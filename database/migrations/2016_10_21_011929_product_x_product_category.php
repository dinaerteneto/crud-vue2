<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductXProductCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_x_product_category', function (Blueprint $table) {
            $table->unsignedInteger('id_product');
            $table->unsignedInteger('id_product_category');
            $table->primary(['id_product', 'id_product_category'], 'pk_product_x_category');
            $table->foreign('id_product')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_product_category')->references('id')->on('product_category')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::table('product_x_product_category', function(Blueprint $table) {
            $table->dropForeign('product_x_product_category_id_product_foreign');
            $table->dropForeign('product_x_product_category_id_product_category_foreign');
        });
        */
        Schema::drop('product_x_product_category');
    }
}
