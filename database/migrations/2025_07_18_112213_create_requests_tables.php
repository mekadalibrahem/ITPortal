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
        Schema::create('request_types', function (Blueprint $table) {
            $table->id();
            $table->string("type")->unique();
            
        });
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('isActive')->default(false);
            $table->foreignId('request_template_id')->constrained('request_templates');
            $table->foreignId('type_id')->constrained('request_types')->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::create('requier_data', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("name_en");
            $table->string('type');
            $table->foreignId('requests_id')->constrained('requests')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_types');
        Schema::dropIfExists('requests');
        Schema::dropIfExists('requier_data');
    }
};
