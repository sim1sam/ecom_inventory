<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'pcs_per_box')) {
                $table->unsignedInteger('pcs_per_box')->default(1)->after('qty');
            }
            if (!Schema::hasColumn('products', 'purchase_unit')) {
                $table->string('purchase_unit', 10)->default('pc')->after('pcs_per_box');
            }
        });

        Schema::table('purchase_order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_order_items', 'unit')) {
                $table->string('unit', 10)->default('pc')->after('product_id');
            }
            if (!Schema::hasColumn('purchase_order_items', 'pcs_per_box')) {
                $table->unsignedInteger('pcs_per_box')->default(1)->after('unit');
            }
        });

        Schema::table('purchase_return_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_return_items', 'unit')) {
                $table->string('unit', 10)->default('pc')->after('product_id');
            }
            if (!Schema::hasColumn('purchase_return_items', 'pcs_per_box')) {
                $table->unsignedInteger('pcs_per_box')->default(1)->after('unit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            foreach (['purchase_unit', 'pcs_per_box'] as $col) {
                if (Schema::hasColumn('products', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('purchase_order_items', function (Blueprint $table) {
            foreach (['pcs_per_box', 'unit'] as $col) {
                if (Schema::hasColumn('purchase_order_items', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('purchase_return_items', function (Blueprint $table) {
            foreach (['pcs_per_box', 'unit'] as $col) {
                if (Schema::hasColumn('purchase_return_items', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
