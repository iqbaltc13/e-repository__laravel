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
        $this->table_name =  'journal_reviews';
        $this->schema = Schema::connection($this->getConnection());
    }

    public function up(): void
    {
        $this->schema->create($this->table_name, function (Blueprint $table) {
            $table->string('id',255)->primary();
            $table->string('journal_id',255)->constrained()->onDelete('cascade');
            $table->string('reviewer_id',255)->constrained('users')->onDelete('cascade');
            $table->text('comments')->nullable();
            $table->enum('recommendation', ['accept', 'minor_revision', 'major_revision', 'reject']);
            $table->integer('rating')->nullable(); // 1-5 scale
            $table->timestamp('reviewed_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unique(['journal_id', 'reviewer_id']);
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
