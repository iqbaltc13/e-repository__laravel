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
        $this->table_name =  'journal_categories';
        $this->schema = Schema::connection($this->getConnection());
    }

    public function up(): void
    {
        $this->schema->create($this->table_name, function (Blueprint $table) {
            $table->string('id',255)->primary();
            $table->bigInteger('eprintid')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
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
        $this->schema->dropIfExists($this->table_name);
    }
};
