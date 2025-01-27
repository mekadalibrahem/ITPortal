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
        if(Schema::hasTable('departments') && Schema::hasTable('employees')){
            Schema::table('departments' , function (Blueprint $table ){
                $table->unsignedBigInteger('manager_id')->nullable();
                $table->foreign("manager_id")->references('id')->on('employees')->nullOnDelete()->cascadeOnUpdate();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        if(Schema::hasTable("departments")){
            Schema::table("departments" , function (Blueprint $table){
              
                $table->dropColumn('manager_id');
            });
        }
    }
};
