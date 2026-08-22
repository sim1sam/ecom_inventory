<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('navbar_menu_color', 20)->nullable()->after('background_color');
            $table->string('navbar_menu_active_color', 20)->nullable()->after('navbar_menu_color');
            $table->string('navbar_bg_color', 20)->nullable()->after('navbar_menu_active_color');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['navbar_menu_color', 'navbar_menu_active_color', 'navbar_bg_color']);
        });
    }
};
