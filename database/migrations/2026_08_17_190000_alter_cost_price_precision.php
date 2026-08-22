<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('products', 'cost_price')) {
            DB::statement('ALTER TABLE products MODIFY cost_price DECIMAL(12,4) NOT NULL DEFAULT 0');
        }

        if (Schema::hasColumn('stock_movements', 'unit_cost')) {
            DB::statement('ALTER TABLE stock_movements MODIFY unit_cost DECIMAL(12,4) NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'cost_price')) {
            DB::statement('ALTER TABLE products MODIFY cost_price DECIMAL(12,2) NOT NULL DEFAULT 0');
        }

        if (Schema::hasColumn('stock_movements', 'unit_cost')) {
            DB::statement('ALTER TABLE stock_movements MODIFY unit_cost DECIMAL(12,2) NULL');
        }
    }
};
