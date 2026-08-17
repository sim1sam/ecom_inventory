<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('is_default')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        $defaultId = DB::table('warehouses')->insertGetId([
            'name' => 'Default Warehouse',
            'code' => 'WH-001',
            'is_default' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'barcode')) {
                $table->string('barcode')->nullable()->after('sku');
            }
            if (!Schema::hasColumn('products', 'low_stock_threshold')) {
                $table->integer('low_stock_threshold')->default(5)->after('qty');
            }
        });

        Schema::create('warehouse_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty')->default(0);
            $table->timestamps();
            $table->unique(['warehouse_id', 'product_id']);
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->string('type', 30);
            $table->string('reason', 50)->nullable();
            $table->integer('qty');
            $table->integer('qty_before')->default(0);
            $table->integer('qty_after')->default(0);
            $table->string('reference_no')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('related_id')->nullable();
            $table->timestamps();
            $table->index(['product_id', 'warehouse_id']);
            $table->index('type');
        });

        if (Schema::hasTable('products')) {
            $now = now();
            $products = DB::table('products')->select('id', 'qty', 'sku', 'barcode')->get();
            foreach ($products as $product) {
                DB::table('warehouse_stocks')->insert([
                    'warehouse_id' => $defaultId,
                    'product_id' => $product->id,
                    'qty' => (int) $product->qty,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                if (empty($product->barcode)) {
                    DB::table('products')->where('id', $product->id)->update([
                        'barcode' => 'P'.str_pad((string) $product->id, 10, '0', STR_PAD_LEFT),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('warehouse_stocks');
        Schema::dropIfExists('warehouses');

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'barcode')) {
                $table->dropColumn('barcode');
            }
            if (Schema::hasColumn('products', 'low_stock_threshold')) {
                $table->dropColumn('low_stock_threshold');
            }
        });
    }
};
