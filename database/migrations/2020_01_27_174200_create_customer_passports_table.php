<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_passports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passport_no')->nullable();
            $table->tinyInteger('passport_type')->comment('1=General | 2=Government | 3=Others');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('issue_location')->nullable();
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
        Schema::dropIfExists('customer_passports');
    }
}
