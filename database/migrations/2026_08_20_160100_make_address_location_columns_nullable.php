<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('addresses')) {
            return;
        }

        // Drop foreign keys if present, then allow null on location columns.
        $this->dropForeignIfExists('addresses', 'addresses_state_id_foreign');
        $this->dropForeignIfExists('addresses', 'addresses_city_id_foreign');
        $this->dropForeignIfExists('addresses', 'addresses_country_id_foreign');

        DB::statement('ALTER TABLE addresses MODIFY state_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE addresses MODIFY city_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE addresses MODIFY country_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE addresses MODIFY zip_code VARCHAR(255) NULL');
    }

    public function down(): void
    {
        // Keep nullable; reverting to NOT NULL would break existing rows.
    }

    protected function dropForeignIfExists(string $table, string $keyName): void
    {
        $db = DB::getDatabaseName();
        $exists = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', $db)
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_NAME', $keyName)
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->exists();

        if ($exists) {
            DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$keyName}`");
        }
    }
};
