<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function __construct()
    {
        $this->table_name =  'departments';
        $this->schema = Schema::connection($this->getConnection());
    }

    public function up(): void
    {
        $this->schema->create($this->table_name, function (Blueprint $table) {
            $table->string('id',255)->primary();
            $table->string('department_code', 10)->unique();
            $table->string('department_name');
            $table->foreignId('faculty_id')->constrained('faculty')->onDelete('cascade');
            $table->enum('jenjang', ['D3', 'D4', 'S1', 'S2', 'S3']);
            $table->enum('akreditasi', ['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi'])->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('head_name', 100)->nullable();
            $table->integer('kapasitas_mahasiswa')->default(0);
            $table->string('email', 100)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table_name);
    }
};
