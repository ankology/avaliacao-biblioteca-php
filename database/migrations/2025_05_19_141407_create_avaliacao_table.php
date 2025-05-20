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
        Schema::create('avaliacao', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('nota');
            $table->text('descricao')->nullable();

            $table->foreignId('usuario_id')->constrained(
                table: 'usuario', indexName: 'avaliacao_usuario_id'
            );
            $table->foreignId('livro_id')->constrained(
                table: 'livro', indexName: 'avaliacao_livro_id'
            );
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropForeign('avaliacao_usuario_id_foreign');
        $table->dropForeign('avaliacao_livro_id_foreign');
        Schema::dropIfExists('avaliacao');
    }
};
