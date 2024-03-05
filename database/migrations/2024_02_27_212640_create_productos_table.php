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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',45);
            $table->string('nombre',45);
            $table->integer('stock')->unsigned()->nullable()->default(0);
            $table->string('descripcion',255)->nullable();
            $table->string('img_path',255)->nullable();
            $table->tinyInteger('estado')->default(1);
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->OnDelete('set null');
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
        Schema::dropIfExists('productos');
    }
};
