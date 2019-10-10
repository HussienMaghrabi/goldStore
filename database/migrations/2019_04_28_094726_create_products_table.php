<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->longText('desc')->nullable();
            $table->integer('view')->default(0);
            $table->integer('caliber')->nullable();
            $table->integer('gram')->nullable();
            $table->enum('bill', [1,2])->default(1);
            $table->double('money')->default(0);
            $table->enum('price_statuse', [1,2])->default(1);
            $table->enum('pinned', [1,2])->default(1);
            $table->double('price')->default(0);
            $table->string('phone');
            $table->enum('msg', [1,2])->default(1);
            $table->enum('video', [1,2])->default(1);
            $table->enum('repost', [1,2])->default(1);
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('sub_category_id')->nullable();
            $table->enum('status', [1,2])->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
