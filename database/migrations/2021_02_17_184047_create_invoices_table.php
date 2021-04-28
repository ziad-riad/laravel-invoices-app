<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_number');
            $table->date('invoice_date')->nullable;
            $table->date('due_date')->nullable;
            $table->string('product',50);
            //$table->string('section');
            $table->bigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('Amount_collection',8,2);
            $table->decimal('Amount_commission',8,2);
            $table->decimal('discount',8,2);
            $table->decimal('value_tax',8,2);
            $table->string('rate_tax',999);
            $table->decimal('total');
            $table->string('status',50);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->date('Payment_Date')->nullable();
            $table->string('user');
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
