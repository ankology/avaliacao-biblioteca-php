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
        Schema::create('livro', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->date('data_publicacao');
            $table->text('sinopse')->nullable();
            $table->foreignId('editora_id')->constrained(
                table: 'editora', indexName: 'livro_editora_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropForeign('livro_editora_id_foreign');
        Schema::dropIfExists('livro');
    }
};
