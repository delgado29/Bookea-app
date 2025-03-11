<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('business_user', function (Blueprint $table) {
            // Eliminar la columna 'position'
            $table->dropColumn('position');

            // Agregar la columna 'role_id'
            $table->unsignedBigInteger('role_id')->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('business_user', function (Blueprint $table) {
            // Volver a agregar la columna 'position' en caso de rollback
            $table->string('position')->nullable();

            // Eliminar la columna 'role_id'
            $table->dropColumn('role_id');
        });
    }
};
