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
        Schema::create('indices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('livro_id');
            $table->foreign( 'livro_id' )->references( 'id' )->on( 'livros' );
            $table->unsignedBigInteger('indice_pai_id')->nullable();
            $table->foreign( 'indice_pai_id' )->references( 'id' )->on( 'indices' );
            $table->string('titulo');
            $table->unsignedSmallInteger('pagina');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indices');
    }
};
