<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('business_user', function (Blueprint $table) {
            $table->string('position')->nullable(); // Añadir columna de posición
        });
    }
    
    public function down()
    {
        Schema::table('business_user', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
