<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            
            $table->bigIncrements('id');
            $table->timestamp('created_on');
<<<<<<< HEAD
            $table->integer('external_id');
            $table->string('describe')->length(1000)->nullable()->default(NULL);
=======
            $table->unsignedBigInteger('external_id');
            $table->string('describe')->length(1000)->default(NULL);
>>>>>>> cdde48ce852857f8420cec12acf6b303763bac24
            $table->string('name')->length(200);
            $table->float('price', 8, 2);
            $table->integer('quantity');


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
