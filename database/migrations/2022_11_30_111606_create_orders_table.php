<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('handled_by')->index()->nullable();
            $table->foreign('handled_by')->references('id')->on('users');
            $table->string('reference_code');
            $table->text('notes')->nullable();
            $table->text('delivery_address');
            $table->double('total_amount');
            $table->enum('status', ['in-progress', 'submitted', 'paid','delivered','canceled']);
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
        Schema::dropIfExists('orders');
    }
};
