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
        Schema::create('livro_autor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livro_id')->constrained(
                table: 'livro', indexName: 'livro_autor_livro_id' 
            );
            $table->foreignId('autor_id')->constrained(
                table: 'autor', indexName: 'livro_autor_autor_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropForeign('livro_autor_livro_id_foreign');
        $table->dropForeign('livro_autor_autor_id_foreign');
        Schema::dropIfExists('livro_autor');
    }
};
