<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 30)->unique();
            $table->tinyInteger('is_base')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        DB::table('units')->insert([
            ['name' => 'Pc', 'code' => 'pc', 'is_base' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Box', 'code' => 'box', 'is_base' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
