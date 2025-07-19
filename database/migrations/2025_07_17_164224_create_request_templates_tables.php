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
        Schema::create('request_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            
            $table->timestamps();
        });
        Schema::create('request_tamplates_steps', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('role');
            $table->foreignId('department_id')->constrained('departments');
          
            $table->timestamps();
        });
        Schema::create('order_steps', function(Blueprint $table){
            $table->id();
            $table->unsignedInteger('order');
            $table->foreignId('request_tamplates_steps_id')->constrained('request_tamplates_steps')->cascadeOnUpdate();
            $table->foreignId('request_template_id')->constrained('request_templates')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_templates');
        Schema::dropIfExists('request_tamplates_steps');
        Schema::dropIfExists('order_steps');

    }
};
