<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan default(2) jika ingin role_id otomatis = 2
            $table->foreignId('role_id')
                  ->nullable()
                  ->default(2)
                  ->constrained()
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Harus drop foreign key & kolom saat rollback
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
