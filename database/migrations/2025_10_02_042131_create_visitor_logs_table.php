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
        $this->table_name =  'visitor_logs';
        $this->schema = Schema::connection($this->getConnection());
    }

    public function up(): void
    {
        $this->schema->create($this->table_name, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id', 255)->nullable();
            $table->ipAddress('ip')->nullable();
            $table->text('endpoint')->nullable();
            $table->dateTime('accessed_at')->nullable();

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
