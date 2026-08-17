<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_number')->unique();
            $table->unsignedBigInteger('expense_category_id');
            $table->string('title');
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->string('payment_method', 50)->default('cash');
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('expense_category_id')->references('id')->on('expense_categories')->restrictOnDelete();
        });

        $now = now();
        $categories = ['Rent', 'Salary', 'Electricity', 'Internet', 'Transport', 'Marketing', 'Office Supplies', 'Maintenance', 'Other'];
        foreach ($categories as $name) {
            DB::table('expense_categories')->insert([
                'name' => $name,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
    }
};
