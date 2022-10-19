<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 8)->nullable();
            $table->string('tipo_documento', 20);
            $table->string('documento', 10);
            $table->string('nombres', 50);
            $table->string('apellidos', 200);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('lugar_vivienda', 200)->nullable();
            $table->string('pais', 50);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
};
