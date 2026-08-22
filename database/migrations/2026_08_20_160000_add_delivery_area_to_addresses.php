<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('addresses') && ! Schema::hasColumn('addresses', 'delivery_area')) {
            Schema::table('addresses', function (Blueprint $table) {
                $table->string('delivery_area', 20)->default('inside')->after('type');
            });
        }

        if (Schema::hasTable('order_addresses') && ! Schema::hasColumn('order_addresses', 'delivery_area')) {
            Schema::table('order_addresses', function (Blueprint $table) {
                $table->string('delivery_area', 20)->default('inside')->after('shipping_address_type');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('addresses') && Schema::hasColumn('addresses', 'delivery_area')) {
            Schema::table('addresses', function (Blueprint $table) {
                $table->dropColumn('delivery_area');
            });
        }

        if (Schema::hasTable('order_addresses') && Schema::hasColumn('order_addresses', 'delivery_area')) {
            Schema::table('order_addresses', function (Blueprint $table) {
                $table->dropColumn('delivery_area');
            });
        }
    }
};
