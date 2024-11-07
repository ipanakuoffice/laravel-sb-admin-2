<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            // Mengubah kolom tegangan dan dosis ke integer, dengan memberikan instruksi konversi
            DB::statement('ALTER TABLE examinations ALTER COLUMN tegangan TYPE integer USING tegangan::integer');
            DB::statement('ALTER TABLE examinations ALTER COLUMN dosis TYPE integer USING dosis::integer');
            
            // Menambahkan kolom result dan note
            $table->text('result')->nullable()->change();
            $table->text('note')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            // Mengembalikan perubahan kolom tegangan dan dosis ke text
            $table->text('tegangan');
            $table->text('dosis');
            
            // Menghapus kolom result dan note
            $table->dropColumn('result');
            $table->dropColumn('note');
        });
    }
};