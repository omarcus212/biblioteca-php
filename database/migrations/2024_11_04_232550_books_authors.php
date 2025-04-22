<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books_authors', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement()->unsigned();
            $table->unsignedBigInteger('id_books', );
            $table->unsignedBigInteger('id_authors', );
            $table->foreign('id_authors')->references('id')->on('authors');
            $table->foreign('id_books')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
