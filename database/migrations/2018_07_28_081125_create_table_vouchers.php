<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_codes',function (Blueprint $table){
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('recipient_id')->references('id')->on('recipients')->onDelete('cascade');
            $table->integer('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->string('expire_date');
            $table->string('used_on')->nullable();
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
        Schema::dropIfExists('voucher_codes');
    }
}
