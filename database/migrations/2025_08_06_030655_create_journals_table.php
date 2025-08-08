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
        $this->table_name =  'journals';
        $this->schema = Schema::connection($this->getConnection());
    }

    public function up(): void
    {
        $this->schema->create($this->table_name, function (Blueprint $table) {
            $table->string('id',255)->primary();
            $table->bigInteger('eprintid')->nullable();
            $table->string('slug')->unique();
            $table->text('abstract')->nullable();
            $table->text('keywords')->nullable();
            $table->string('author_id',255)->constrained('users')->onDelete('cascade');
            $table->string('category_id',255)->constrained('journal_categories')->onDelete('cascade');
            $table->string('doi')->nullable()->unique();
            $table->string('issn')->nullable();
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->integer('revision_number')->nullable();
            $table->integer('pages_start')->nullable();
            $table->integer('pages_end')->nullable();
            $table->date('publication_date');
            $table->string('publisher')->nullable();
            $table->string('institution')->nullable();
            $table->text('journal_name')->nullable();
            $table->string('language', 10)->default('id')->nullable();
            $table->enum('status', ['draft', 'submitted', 'under_review', 'accepted', 'published', 'rejected'])->default('submitted');
            $table->enum('thesis_type', ['undergraduate (S1)', 'masters (S2)', 'doctoral (S3)'])->default('undergraduate (S1)');
            $table->string('pdf_file')->nullable();
            $table->string('other_document_file')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->index(['status', 'publication_date']);
            $table->index(['author_id', 'status']);
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
