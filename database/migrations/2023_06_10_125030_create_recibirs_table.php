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
        Schema::create('recibirs', function (Blueprint $table) {
            $table->id();
            $table->string('NombreCli');
            $table->integer('NoReserva');
            $table->dateTime('FechHoraDev');
            $table->decimal('KMactual');
            $table->text('EstadoVeh');
            $table->string('NCombustible');
            $table->text('Comentarios');
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
        Schema::dropIfExists('recibirs');
    }
};
