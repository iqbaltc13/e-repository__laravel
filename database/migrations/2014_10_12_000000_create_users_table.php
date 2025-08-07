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
        $this->table_name =  'users';
        $this->schema = Schema::connection($this->getConnection());
    }

    public function up(): void
    {
        $this->schema->create($this->table_name, function (Blueprint $table) {
            $table->string('id',255)->primary();
            $table->bigInteger('eprint_userid')->nullable();
            $table->string('full_name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'member','editor'])->default('member');
            $table->string('organization')->nullable();
            $table->string('departemen')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->text('bio')->nullable();
            $table->string('phone')->nullable();
            $table->rememberToken();
            $table->string('created_by_id',255)->nullable();
            $table->string('updated_by_id',255)->nullable();
            $table->string('deleted_by_id',255)->nullable();
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
