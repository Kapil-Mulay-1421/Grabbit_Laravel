<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->nullable()->after('reference_id');
            $table->string('billing_address', 500)->nullable()->after('subtotal');
            $table->string('shipping_address', 500)->nullable()->after('billing_address');
            $table->string('payment_method', 50)->nullable()->after('shipping_address');
            $table->text('note')->nullable()->after('payment_method');
            $table->decimal('shipping', 10, 2)->default(0)->after('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'subtotal',
                'billing_address',
                'shipping_address',
                'payment_method',
                'note',
                'shipping',
            ]);
        });
    }
};
