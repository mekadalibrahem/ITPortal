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
        Schema::create('request_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate();
            $table->foreignId('request_id')->constrained('requests')->cascadeOnUpdate();
            $table->foreignId('request_template_id')->constrained('request_templates');
            $table->foreignId('current_step_id')->constrained('request_tamplates_steps');
            $table->string("status");
            $table->string("note")->nullable();
            $table->string("dean");
            $table->string("coordinator");
            $table->timestamp('end_at')->nullable();
            $table->timestamps();
        });
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("value");
            $table->foreignId('request_list_id')->constrained('request_lists')->cascadeOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
        Schema::create('request_logs', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('employee_id')->nullable()->constrained('employees');
            $table->foreignId('request_list_id')->constrained('request_lists');
            $table->foreignId('request_tamplates_step_id')->constrained('request_tamplates_steps');
            $table->text('note')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_lists');
        Schema::dropIfExists('data');
        Schema::dropIfExists('request_logs');
    }
};
